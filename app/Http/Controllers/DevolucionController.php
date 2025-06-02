<?php

namespace App\Http\Controllers;

use App\Models\Factura;
use App\Models\Producto;
use App\Models\Devolucion;
use App\Models\DetalleDevolucion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DevolucionController extends Controller
{
    public function index()
    {
        $devoluciones = Devolucion::with('factura', 'usuario')->latest()->paginate(10);
        return view('devoluciones.index', compact('devoluciones'));
    }


    public function buscarFactura()
    {
        return view('devoluciones.buscar');
    }

    public function mostrarFactura(Request $request)
    {
        $codigo = $request->codigo;
        $factura = Factura::with('detalles.producto', 'devolucion')->where('codigo', $codigo)->first();

        if (!$factura) {
            return back()->with('error', 'Factura no encontrada.');
        }

        if ($factura->devolucion) {
            return back()->with('error', 'Esta factura ya tiene una devolución registrada.');
        }

        return view('devoluciones.seleccionar', compact('factura'));
    }


    public function seleccionar(Factura $factura)
    {
        if ($factura->devolucion) {
            return redirect()->route('facturas_productos.index')->with('error', 'Ya se ha realizado una devolución para esta factura.');
        }

        return view('devoluciones.seleccionar', compact('factura'));
    }

    public function procesar(Request $request)
    {
        $request->validate([
            'factura_id' => 'required|exists:facturas,id',
            'motivo' => 'required|string',
            'productos' => 'required|array',
        ]);

        $factura = Factura::with('devolucion')->findOrFail($request->factura_id);
        if ($factura->devolucion) {
            return redirect()->route('devoluciones.buscar')->with('error', 'Ya existe una devolución para esta factura.');
        }

        $devolucion = Devolucion::create([
            'factura_id' => $factura->id,
            'usuario_id' => Auth::id(),
            'motivo' => $request->motivo,
            'total' => 0,
        ]);

        $totalDevolucion = 0;

        foreach ($request->productos as $detalleFacturaId => $cantidad) {
            $detalle = \App\Models\DetalleFactura::find($detalleFacturaId);
            if ($detalle && $cantidad > 0 && $cantidad <= $detalle->cantidad) {
                $subtotal = $detalle->precio_unitario * $cantidad;
                DetalleDevolucion::create([
                    'devolucion_id' => $devolucion->id,
                    'producto_id' => $detalle->producto_id,
                    'cantidad' => $cantidad,
                    'precio_unitario' => $detalle->precio_unitario,
                    'subtotal' => $subtotal,
                ]);

                $detalle->producto->increment('stock', $cantidad);
                $totalDevolucion += $subtotal;
            }
        }

        $devolucion->update(['total' => $totalDevolucion]);

        return redirect()->route('devoluciones.buscar')->with('success', 'Devolución procesada correctamente.');
    }

    public function show($id)
    {
        $devolucion = Devolucion::with(['factura.cliente', 'usuario', 'detalles.producto'])->findOrFail($id);

        return view('devoluciones.show', compact('devolucion'));
    }
}
