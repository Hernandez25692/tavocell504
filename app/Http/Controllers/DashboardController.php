<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Factura;
use App\Models\Reparacion;
use App\Models\SuscripcionNetflix;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\SalidaCaja;

class DashboardController extends Controller
{
    public function mostrar()
    {
        $hoy = Carbon::today();

        /* =========================
        INGRESOS REALES DEL DÍA
    ==========================*/

        // 1️⃣ Facturas de productos
        $ventasProductos = Factura::whereDate('created_at', $hoy)
            ->whereHas('detalles', fn($q) => $q->whereNotNull('producto_id'))
            ->sum('total');

        // 2️⃣ Facturas de reparaciones
        $ventasReparaciones = Factura::whereDate('created_at', $hoy)
            ->whereHas('detalles', fn($q) => $q->whereNull('producto_id'))
            ->sum('total');

        // 3️⃣ Abonos NO facturados (reparaciones en proceso)
        $abonosReparaciones = Reparacion::whereDate('created_at', $hoy)
            ->whereNull('factura_id')
            ->sum('abono');

        // ✅ INGRESOS DEL DÍA (CORRECTO)
        $ingresosTotales = $ventasProductos + $ventasReparaciones + $abonosReparaciones;

        /* =========================
        OTROS INDICADORES
    ==========================*/

        $salidasCajaHoy = SalidaCaja::whereDate('created_at', $hoy)->sum('monto');

        $totalFacturasHoy = Factura::whereDate('created_at', $hoy)->count();

        $reparacionesActivas = Reparacion::whereIn('estado', ['recibido', 'en_proceso'])->count();

        /* =========================
        GRÁFICO (SOLO FACTURADO)
    ==========================*/
        $ingresosPorDia = Factura::select(
            DB::raw("DATE(created_at) as fecha"),
            DB::raw("SUM(total) as total")
        )
            ->whereDate('created_at', '>=', Carbon::now()->subDays(6))
            ->groupBy('fecha')
            ->orderBy('fecha')
            ->get();

        $suscripcionesProximas = SuscripcionNetflix::where('estado', 'activo')
            ->whereBetween('fecha_fin', [$hoy, $hoy->copy()->addDays(5)])
            ->with('cliente')
            ->get();

        return view('dashboard', compact(
            'ingresosTotales',
            'salidasCajaHoy',
            'totalFacturasHoy',
            'reparacionesActivas',
            'ingresosPorDia',
            'suscripcionesProximas'
        ));
    }
}
