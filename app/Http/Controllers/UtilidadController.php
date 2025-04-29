<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Factura;
use App\Models\DetalleFactura;
use App\Models\Producto;
use App\Models\Reparacion;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class UtilidadController extends Controller
{
    public function index(Request $request)
    {
        $desde = $request->input('desde');
        $hasta = $request->input('hasta');

        $queryFecha = function ($q) use ($desde, $hasta) {
            if ($desde) $q->whereDate('created_at', '>=', $desde);
            if ($hasta) $q->whereDate('created_at', '<=', $hasta);
        };

        // Reparaciones con utilidad
        $reparaciones = Reparacion::whereNotNull('costo_tavocell')
            ->where($queryFecha)
            ->get()
            ->map(function ($rep) {
                $ganancia = $rep->costo_total - $rep->costo_tavocell;
                return [
                    'codigo' => $rep->id,
                    'cliente' => $rep->cliente->nombre ?? 'Desconocido',
                    'total' => $rep->costo_total,
                    'costo_tavocell' => $rep->costo_tavocell,
                    'ganancia' => $ganancia,
                    'fecha' => $rep->created_at->format('Y-m-d'),
                ];
            });

        // Productos vendidos con utilidad (ahora usando el precio histórico)
        $detalles = DetalleFactura::with('factura', 'producto')
            ->whereHas('producto')
            ->whereHas('factura', $queryFecha)
            ->get();

        $productos = $detalles->map(function ($detalle) {
            $costoCompraUnitario = $detalle->precio_compra_unitario; // <--- aquí

            $ganancia = ($detalle->precio_unitario - $costoCompraUnitario) * $detalle->cantidad;

            return [
                'producto' => $detalle->producto->nombre,
                'cantidad' => $detalle->cantidad,
                'venta' => $detalle->precio_unitario * $detalle->cantidad,
                'compra' => $costoCompraUnitario * $detalle->cantidad,
                'ganancia' => $ganancia,
                'fecha' => $detalle->factura->created_at->format('Y-m-d'),
            ];
        });


        // Totales globales
        $gananciaReparaciones = $reparaciones->sum('ganancia');
        $gananciaProductos = $productos->sum('ganancia');
        $gananciaTotal = $gananciaReparaciones + $gananciaProductos;

        return view('utilidades.index', compact(
            'reparaciones',
            'productos',
            'gananciaReparaciones',
            'gananciaProductos',
            'gananciaTotal',
            'desde',
            'hasta'
        ));
    }
}
