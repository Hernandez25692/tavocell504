<?php

namespace App\Http\Controllers;

use App\Models\Factura;
use App\Models\DetalleFactura;
use App\Models\Producto;
use App\Models\Cliente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Str;


class FacturaProductoController extends Controller
{
    public function index(Request $request)
    {
        $query = Factura::with('cliente', 'usuario', 'detalles.producto')
            ->whereHas('detalles', fn($q) => $q->whereNotNull('producto_id'));

        if ($request->filled('codigo')) {
            $codigo = $request->codigo;
            if (Str::startsWith($codigo, 'PROD-')) {
                $id = (int) Str::after($codigo, 'PROD-');
                $query->where('id', $id);
            } elseif (is_numeric($codigo)) {
                $query->where('id', $codigo);
            } else {
                $query->where('codigo', $codigo); // Por si se usa campo 'codigo' real
            }
        }

        $facturas = $query->latest()->paginate(10);

        return view('facturas_productos.index', compact('facturas'));
    }


    public function create()
    {
        $clientes = Cliente::all();
        $productos = Producto::all();
        return view('facturas_productos.create', compact('clientes', 'productos'));
    }

    public function store(Request $request)
    {
        $productos = json_decode($request->productos, true);
        $request->merge(['productos' => $productos]);

        $request->validate([
            'cliente_id' => 'nullable|exists:clientes,id',
            'productos' => 'required|array|min:1',
            'productos.*.id' => 'required|exists:productos,id',
            'productos.*.cantidad' => 'required|integer|min:1',
            'total' => 'required|numeric|min:0',
            'monto_recibido' => 'required|numeric|min:0',
        ]);

        DB::beginTransaction();
        try {
            $subtotal = 0;
            $detalles = [];

            foreach ($productos as $item) {
                $producto = Producto::findOrFail($item['id']);
                if ($producto->stock < $item['cantidad']) {
                    throw new \Exception("Stock insuficiente para: {$producto->nombre}");
                }

                $subtotalProducto = $producto->precio_venta * $item['cantidad'];
                $producto->decrement('stock', $item['cantidad']);

                $detalles[] = [
                    'producto_id' => $producto->id,
                    'cantidad' => $item['cantidad'],
                    'precio_unitario' => $producto->precio_venta,
                    'precio_compra_unitario' => $producto->precio_compra, // <<<<<< AQUI SE AGREGA
                    'subtotal' => $subtotalProducto,
                ];

                $subtotal += $subtotalProducto;

                // Registrar también en histórico (por si quieres tenerlo archivado)
                DB::table('historial_precio_productos')->insert([
                    'producto_id' => $producto->id,
                    'precio_compra' => $producto->precio_compra,
                    'fecha_registro' => now(),
                ]);
            }

            $factura = Factura::create([
                'cliente_id' => $request->cliente_id,
                'usuario_id' => Auth::id(),
                'metodo_pago' => 'Efectivo',
                'subtotal' => $subtotal,
                'total' => $subtotal,
                'monto_recibido' => $request->monto_recibido,
                'cambio' => $request->monto_recibido - $subtotal,
            ]);
            $factura->codigo = 'PROD-' . str_pad($factura->id, 5, '0', STR_PAD_LEFT);
            $factura->save();

            foreach ($detalles as $detalle) {
                $factura->detalles()->create($detalle);
            }

            DB::commit();
            return redirect()->route('facturas_productos.show', $factura->id)->with('success', 'Factura generada correctamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error al generar la factura: ' . $e->getMessage());
        }
    }

    public function show(Factura $factura)
    {
        $factura->load('cliente', 'usuario', 'detalles.producto');
        return view('facturas_productos.show', compact('factura'));
    }

    public function descargarPDF(Factura $factura, Request $request)
    {
        $factura->load('cliente', 'usuario', 'detalles.producto');
        $esCopia = $request->has('copia') && $request->copia == 1;

        if (!$esCopia && !$factura->impresa) {
            $factura->impresa = true;
            $factura->save();
        }

        $pdf = Pdf::loadView('facturas_productos.factura_pdf', compact('factura', 'esCopia'));
        return $pdf->stream("factura_{$factura->id}.pdf");
    }
}
