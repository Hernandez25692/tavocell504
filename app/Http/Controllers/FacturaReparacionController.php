<?php

namespace App\Http\Controllers;

use App\Models\Factura;
use App\Models\Reparacion;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class FacturaReparacionController extends Controller
{
    public function index(Request $request)
    {
        $query = Factura::with(['cliente', 'usuario', 'detalles'])
            ->whereHas('detalles', fn($q) => $q->whereNull('producto_id'));

        /* =========================
        FILTRO POR CÓDIGO / ID
    ==========================*/
        if ($request->filled('codigo')) {
            $codigo = $request->codigo;

            if (Str::startsWith($codigo, 'REP-')) {
                $id = (int) Str::after($codigo, 'REP-');
                $query->where('id', $id);
            } elseif (is_numeric($codigo)) {
                $query->where('id', $codigo);
            } else {
                $query->where('codigo', $codigo);
            }
        }

        /* =========================
        FILTRO POR CLIENTE
    ==========================*/
        if ($request->filled('cliente')) {
            $query->whereHas('cliente', function ($q) use ($request) {
                $q->where('nombre', 'like', '%' . $request->cliente . '%');
            });
        }

        /* =========================
        FILTRO POR USUARIO
    ==========================*/
        if ($request->filled('usuario')) {
            $query->whereHas('usuario', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->usuario . '%');
            });
        }

        /* =========================
        FILTRO POR FECHAS
    ==========================*/
        if ($request->filled('desde')) {
            $query->whereDate('created_at', '>=', $request->desde);
        }

        if ($request->filled('hasta')) {
            $query->whereDate('created_at', '<=', $request->hasta);
        }

        /* =========================
        PAGINACIÓN
    ==========================*/
        $facturas = $query->latest()->paginate(10)->withQueryString();

        /* =========================
        REPARACIONES ASOCIADAS
    ==========================*/
        $reparaciones = Reparacion::whereIn('factura_id', $facturas->pluck('id'))
            ->get()
            ->keyBy('factura_id');

        /* =========================
        TOTALES GENERALES
    ==========================*/
        $totalFacturas = $query->count();

        $totalMonto = Reparacion::whereIn(
            'factura_id',
            $query->pluck('id')
        )->sum('costo_total');

        return view('facturas_reparaciones.index', compact(
            'facturas',
            'reparaciones',
            'totalFacturas',
            'totalMonto'
        ));
    }

    public function show(Factura $factura)
    {
        $factura->load('cliente', 'usuario', 'detalles');
        $reparacion = Reparacion::where('factura_id', $factura->id)->first();
        return view('facturas_reparaciones.show', compact('factura', 'reparacion'));
    }

    public function pdf(Factura $factura)
    {
        $factura->load('cliente', 'usuario', 'detalles');
        $reparacion = Reparacion::where('factura_id', $factura->id)->first();

        $pdf = Pdf::loadView('facturas_reparaciones.factura_pdf', compact('factura', 'reparacion'));

        return $pdf->download("Factura_Reparacion_{$factura->id}.pdf");
    }


    public function destroy(Factura $factura)
    {
        $reparacion = Reparacion::where('factura_id', $factura->id)->first();
        if ($reparacion) {
            $reparacion->update(['factura_id' => null, 'estado' => 'recibido']);
        }

        $factura->detalles()->delete();
        $factura->delete();

        return redirect()->route('facturas_reparaciones.index')->with('success', 'Factura eliminada y reparación restablecida.');
    }
}
