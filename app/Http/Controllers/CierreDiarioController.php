<?php

namespace App\Http\Controllers;

use App\Models\CierreDiario;
use App\Models\Factura;
use App\Models\Reparacion;
use App\Models\AbonoReparacion;
use App\Models\SalidaCaja;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class CierreDiarioController extends Controller
{
    public function index()
    {
        $cierres = CierreDiario::with('usuario')->latest()->get();
        return view('cierres.index', compact('cierres'));
    }

    public function store(Request $request)
    {
        $fechaHoy = Carbon::today();

        if (CierreDiario::where('fecha', $fechaHoy)->exists()) {
            return redirect()->route('cierres.index')->with('error', 'El cierre de hoy ya fue realizado.');
        }

        $totalVentas = Factura::whereDate('created_at', $fechaHoy)
            ->whereHas('detalles', fn($q) => $q->whereNotNull('producto_id'))
            ->sum('total');

        $totalReparaciones = Factura::whereDate('created_at', $fechaHoy)
            ->whereHas('detalles', fn($q) => $q->whereNull('producto_id'))
            ->sum('total');

        // Solo abonos que no están en reparaciones ya facturadas
        $facturadas = Reparacion::whereNotNull('factura_id')->pluck('id');
        $totalAbonos = AbonoReparacion::whereDate('created_at', $fechaHoy)
            ->whereNotIn('reparacion_id', $facturadas)
            ->sum('monto');

        // NUEVO: Salidas de caja
        $totalSalidas = SalidaCaja::whereDate('created_at', $fechaHoy)->sum('monto');

        // Total neto en sistema = ingresos - egresos
        $totalEfectivo = $totalVentas + $totalReparaciones + $totalAbonos - $totalSalidas;

        $cierre = CierreDiario::create([
            'fecha' => $fechaHoy,
            'total_ventas' => $totalVentas,
            'total_reparaciones' => $totalReparaciones,
            'total_abonos' => $totalAbonos,
            'total_salidas' => $totalSalidas,
            'total_efectivo' => $totalEfectivo,
            'usuario_id' => auth()->id(),
        ]);

        return redirect()->route('cierres.index')->with('success', 'Cierre de hoy realizado. Puedes ingresar el efectivo físico.');
    }

    public function actualizarEfectivo(Request $request, $id)
    {
        $request->validate([
            'efectivo_fisico' => 'required|numeric|min:0',
        ]);

        $cierre = CierreDiario::findOrFail($id);
        $cierre->efectivo_fisico = $request->efectivo_fisico;
        $cierre->save();

        return back()->with('success', 'Efectivo físico registrado correctamente.');
    }

    public function descargar($id)
    {
        $cierre = CierreDiario::findOrFail($id);

        $diferencia = $cierre->efectivo_fisico !== null
            ? $cierre->efectivo_fisico - $cierre->total_efectivo
            : null;

        $pdf = Pdf::loadView('cierres.reporte_pdf', [
            'fecha' => $cierre->fecha,
            'ventas' => $cierre->total_ventas,
            'reparaciones' => $cierre->total_reparaciones,
            'abonos' => $cierre->total_abonos,
            'salidas' => $cierre->total_salidas, 
            'totalFinal' => $cierre->total_efectivo,
            'efectivo_fisico' => $cierre->efectivo_fisico,
            'diferencia' => $diferencia,
            'usuario' => $cierre->usuario->name
        ]);

        return $pdf->download("reporte_z_cierre_{$cierre->fecha}.pdf");
    }
}
