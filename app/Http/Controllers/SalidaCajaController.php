<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SalidaCaja;
use Illuminate\Support\Facades\Auth;

class SalidaCajaController extends Controller
{
    public function index(Request $request)
    {
        $buscar = $request->buscar;
        $desde = $request->desde;
        $hasta = $request->hasta;

        $salidas = \App\Models\SalidaCaja::with('usuario')
            ->when($buscar, function ($q) use ($buscar) {
                $q->where('motivo', 'like', "%$buscar%")
                    ->orWhereHas('usuario', fn($u) => $u->where('name', 'like', "%$buscar%"));
            })
            ->when($desde, fn($q) => $q->whereDate('created_at', '>=', $desde))
            ->when($hasta, fn($q) => $q->whereDate('created_at', '<=', $hasta))
            ->latest()
            ->paginate(10);

        return view('salidas_caja.index', compact('salidas'));
    }



    public function create()
    {
        return view('salidas_caja.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'monto' => 'required|numeric|min:0.01',
            'motivo' => 'required|string|max:255',
            'comprobante' => 'nullable|file|mimes:jpg,png,pdf|max:2048',
        ]);

        $data = [
            'usuario_id' => Auth::id(),
            'monto' => $request->monto,
            'motivo' => $request->motivo,
        ];

        if ($request->hasFile('comprobante')) {
            $data['comprobante'] = $request->file('comprobante')->store('comprobantes_salidas', 'public');
        }

        SalidaCaja::create($data);

        return redirect()->route('salidas-caja.index')->with('success', 'Salida de caja registrada correctamente.');
    }
}
