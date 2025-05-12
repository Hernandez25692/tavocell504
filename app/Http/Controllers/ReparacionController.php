<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Factura;
use App\Models\DetalleFactura;
use App\Models\Reparacion;
use App\Models\Cliente;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;
use Milon\Barcode\DNS2D;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class ReparacionController extends Controller
{
    public function index(Request $request)
    {
        $query = Reparacion::with('cliente');

        // Filtro por cliente
        if ($request->filled('cliente')) {
            $query->whereHas('cliente', function ($q) use ($request) {
                $q->where('nombre', 'like', '%' . $request->cliente . '%');
            });
        }

        if ($request->filled('identidad')) {
            $query->whereHas('cliente', function ($q) use ($request) {
                $q->where('identidad', 'like', '%' . $request->identidad . '%');
            });
        }

        // Filtro por estado
        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }

        // Filtro por fechas
        if ($request->filled('desde')) {
            $query->whereDate('fecha_ingreso', '>=', $request->desde);
        }
        if ($request->filled('hasta')) {
            $query->whereDate('fecha_ingreso', '<=', $request->hasta);
        }
        if ($request->filled('codigo')) {
            $codigo = $request->codigo;
            if (Str::startsWith($codigo, 'REP-')) {
                $idBuscado = (int) Str::after($codigo, 'REP-');
                $query->where('id', $idBuscado);
            } else {
                $query->where('id', -1); // No coincide, resultado vacío
            }
        }


        // APLICAR PAGINACIÓN CORRECTAMENTE
        $reparaciones = $query->orderByDesc('fecha_ingreso')->paginate(10);

        return view('reparaciones.index', compact('reparaciones'));
    }



    public function create()
    {
        $clientes = Cliente::all();
        $tecnicos = User::all(); // Puedes filtrar por rol
        return view('reparaciones.create', compact('clientes', 'tecnicos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'marca' => 'required|string|max:100',
            'modelo' => 'required|string|max:100',
            'imei' => 'nullable|string|max:50',
            'falla_reportada' => 'required|string',
            'accesorios' => 'nullable|string',
            'tecnico_id' => 'required|exists:users,id',
            'fecha_ingreso' => 'required|date',
            'costo_total' => 'required|numeric|min:0',
            'costo_tavocell' => 'nullable|numeric|min:0',
            'abono' => 'nullable|numeric|min:0|max:' . $request->input('costo_total'),
        ]);

        $costo_total = $request->costo_total;
        $costo_tavocell = $request->costo_tavocell ?? 0;
        $ganancia = $costo_total - $costo_tavocell;

        $reparacion = Reparacion::create([
            'cliente_id' => $request->cliente_id,
            'marca' => $request->marca,
            'modelo' => $request->modelo,
            'imei' => $request->imei,
            'falla_reportada' => $request->falla_reportada,
            'accesorios' => $request->accesorios,
            'tecnico_id' => $request->tecnico_id,
            'fecha_ingreso' => $request->fecha_ingreso,
            'costo_total' => $costo_total,
            'costo_tavocell' => $costo_tavocell,
            'ganancia' => $ganancia,
            'abono' => $request->abono ?? 0,
            'estado' => 'recibido',
        ]);

        if ($request->filled('abono') && $request->abono > 0) {
            \App\Models\AbonoReparacion::create([
                'reparacion_id' => $reparacion->id,
                'monto' => $request->abono,
                'metodo_pago' => 'Inicial',
                'observaciones' => 'Abono inicial al recibir equipo',
            ]);
        }

        // Generar código QR como ya lo haces...
        $qr = new \Milon\Barcode\DNS2D();
        $qr->setStorPath(storage_path('framework/qr'));
        $url = route('consulta.reparacion.publica', ['id' => $reparacion->id]);
        $qrData = $qr->getBarcodePNG($url, 'QRCODE');

        $qrFileName = 'qr_' . $reparacion->id . '_' . \Illuminate\Support\Str::random(8) . '.png';
        $qrDir = public_path('storage/qr');
        $qrPath = $qrDir . '/' . $qrFileName;

        if (!\File::exists($qrDir)) {
            \File::makeDirectory($qrDir, 0755, true);
        }

        file_put_contents($qrPath, base64_decode($qrData));

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('reparaciones.comprobante_pdf', [
            'reparacion' => $reparacion,
            'qrPath' => 'file://' . $qrPath
        ]);

        $pdfName = "comprobante_reparacion_{$reparacion->id}.pdf";
        \Storage::disk('public')->put("comprobantes/{$pdfName}", $pdf->output());

        return redirect()->route('reparaciones.index')
            ->with('success', 'Reparación registrada correctamente.')
            ->with('comprobante', $pdfName)
            ->with('comprobante_id', $reparacion->id);
    }





    public function facturar(Reparacion $reparacion)
    {
        if ($reparacion->factura_id) {
            return redirect()->back()->with('error', 'Ya ha sido facturada.');
        }

        $cliente_id = $reparacion->cliente?->id;
        $subtotal = $reparacion->costo_total;
        $saldo = $subtotal - $reparacion->abono;

        // Creamos factura sin código aún
        $factura = Factura::create([
            'cliente_id' => $cliente_id,
            'usuario_id' => Auth::id(),
            'metodo_pago' => 'Efectivo',
            'subtotal' => $subtotal,
            'total' => $subtotal,
            'monto_recibido' => $saldo > 0 ? $saldo : 0,
            'cambio' => 0,
        ]);

        // Generamos código tipo REP-00001
        $factura->codigo = 'REP-' . str_pad($factura->id, 5, '0', STR_PAD_LEFT);
        $factura->save();

        $factura->detalles()->create([
            'producto_id' => null,
            'cantidad' => 1,
            'precio_unitario' => $subtotal,
            'subtotal' => $subtotal,
            'descripcion' => "Reparación de {$reparacion->marca} {$reparacion->modelo}",
        ]);

        $reparacion->update([
            'factura_id' => $factura->id,
            'estado' => 'entregado',
        ]);

        return redirect()->route('facturas_reparaciones.show', $factura->id)
            ->with('success', 'Factura generada correctamente.');
    }



    public function abonar(Request $request, Reparacion $reparacion)
    {
        $request->validate([
            'monto' => 'required|numeric|min:0.01',
            'metodo_pago' => 'nullable|string|max:50',
            'observaciones' => 'nullable|string|max:255',
        ]);

        $nuevoAbono = $request->monto;

        // Evitar que se sobrepase el costo total
        if (($reparacion->abono + $nuevoAbono) > $reparacion->costo_total) {
            return back()->with('error', 'El abono supera el costo total de la reparación.');
        }

        // Guardar en historial
        \App\Models\AbonoReparacion::create([
            'reparacion_id' => $reparacion->id,
            'monto' => $nuevoAbono,
            'metodo_pago' => $request->metodo_pago,
            'observaciones' => $request->observaciones,
            'usuario_id' => auth()->id(),
        ]);

        // Actualizar campo acumulado
        $reparacion->abono += $nuevoAbono;
        $reparacion->save();

        return back()->with('success', 'Abono registrado correctamente.');
    }

    public function edit($id)
    {
        $reparacion = Reparacion::findOrFail($id);
        $clientes = Cliente::all();
        $tecnicos = User::all();

        return view('reparaciones.edit', compact('reparacion', 'clientes', 'tecnicos'));
    }

    public function update(Request $request, $id)
    {
        $reparacion = Reparacion::findOrFail($id);

        $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'marca' => 'required|string|max:100',
            'modelo' => 'required|string|max:100',
            'imei' => 'nullable|string|max:50',
            'falla_reportada' => 'required|string',
            'accesorios' => 'nullable|string',
            'tecnico_id' => 'required|exists:users,id',
            'fecha_ingreso' => 'required|date',
            'costo_total' => 'required|numeric|min:0',
            'costo_tavocell' => 'nullable|numeric|min:0',
            'estado' => 'required|in:recibido,en_proceso,listo,entregado',
        ]);

        $ganancia = $request->costo_total - ($request->costo_tavocell ?? 0);

        $reparacion->update([
            'cliente_id' => $request->cliente_id,
            'marca' => $request->marca,
            'modelo' => $request->modelo,
            'imei' => $request->imei,
            'falla_reportada' => $request->falla_reportada,
            'accesorios' => $request->accesorios,
            'tecnico_id' => $request->tecnico_id,
            'fecha_ingreso' => $request->fecha_ingreso,
            'costo_total' => $request->costo_total,
            'costo_tavocell' => $request->costo_tavocell,
            'ganancia' => $ganancia,
            'estado' => $request->estado,
        ]);

        return redirect()->route('reparaciones.index')->with('success', 'Reparación actualizada correctamente.');
    }



    // Métodos vacíos
    public function show(string $id) {}


    public function destroy(string $id) {}
}
