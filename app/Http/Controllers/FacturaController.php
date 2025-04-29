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

class FacturaController extends Controller
{
    public function index()
    {
        $facturas = \App\Models\Factura::with(['cliente', 'detalles', 'detalles.producto', 'usuario'])->latest()->get();

        $facturasProductos = $facturas->filter(function ($factura) {
            return $factura->detalles->first()?->producto_id !== null;
        });

        $facturasReparaciones = $facturas->filter(function ($factura) {
            return $factura->detalles->first()?->producto_id === null;
        });

        return view('facturas.index', compact('facturasProductos', 'facturasReparaciones'));
    }



    public function create()
    {
        $clientes = Cliente::all();
        $productos = Producto::all();
        return view('facturas.create', compact('clientes', 'productos'));
    }

    public function store(Request $request)
    {
        // Decodificar los productos del JSON recibido
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
                    throw new \Exception("Stock insuficiente para el producto: {$producto->nombre}");
                }

                $precioVenta = $producto->precio_venta;
                $precioCompra = $producto->precio_compra; // <-- Tomar precio de compra actual en el momento de la venta
                $cantidad = $item['cantidad'];
                $subtotalProducto = $precioVenta * $cantidad;

                $producto->decrement('stock', $cantidad);

                $detalles[] = [
                    'producto_id' => $producto->id,
                    'cantidad' => $cantidad,
                    'precio_unitario' => $precioVenta,
                    'precio_compra_unitario' => $precioCompra, // <-- Lo guardamos aquí
                    'subtotal' => $subtotalProducto,
                ];

                $subtotal += $subtotalProducto;
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

            foreach ($detalles as $detalle) {
                $factura->detalles()->create($detalle);
            }

            DB::commit();
            return redirect()->route('facturas.show', $factura)->with('success', 'Factura generada correctamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error al generar la factura: ' . $e->getMessage());
        }
    }




    public function show(Factura $factura)
    {
        $factura->load('cliente', 'detalles.producto', 'usuario'); // usuario CARGADO aquí
        return view('facturas.show', compact('factura'));
    }


    public function edit(Factura $factura)
    {
        abort(404); // No implementado
    }

    public function update(Request $request, Factura $factura)
    {
        abort(404); // No implementado
    }

    public function destroy(Factura $factura)
    {
        $factura->delete();
        return redirect()->route('facturas.index')->with('success', 'Factura eliminada.');
    }

    public function descargarPDF(Factura $factura, Request $request)
    {
        $factura->load('cliente', 'detalles.producto', 'usuario');

        $esCopia = $request->has('copia') && $request->copia == 1;

        // Si es original y aún no ha sido impresa, se marca como impresa
        if (!$esCopia && !$factura->impresa) {
            $factura->impresa = true;
            $factura->save();
        }

        $pdf = PDF::loadView('facturas.factura_pdf', compact('factura', 'esCopia'));
        return $pdf->stream("factura_{$factura->id}.pdf");
    }
}
