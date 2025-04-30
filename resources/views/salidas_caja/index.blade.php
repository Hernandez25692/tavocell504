@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto py-10">
    <div class="mb-4 flex justify-between items-center">
        <h2 class="text-xl font-semibold">Salidas de Caja</h2>
        <a href="{{ route('salidas-caja.create') }}" class="bg-indigo-600 text-white px-4 py-2 rounded">+ Nueva</a>
    </div>

    <div class="bg-white shadow rounded">
        <table class="min-w-full text-sm">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-2">Fecha</th>
                    <th class="px-4 py-2">Usuario</th>
                    <th class="px-4 py-2">Monto</th>
                    <th class="px-4 py-2">Motivo</th>
                    <th class="px-4 py-2">Comprobante</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($salidas as $salida)
                    <tr class="border-t">
                        <td class="px-4 py-2">{{ $salida->created_at->format('Y-m-d H:i') }}</td>
                        <td class="px-4 py-2">{{ $salida->usuario->name }}</td>
                        <td class="px-4 py-2 text-red-600 font-bold">L. {{ number_format($salida->monto, 2) }}</td>
                        <td class="px-4 py-2">{{ $salida->motivo }}</td>
                        <td class="px-4 py-2">
                            @if ($salida->comprobante)
                                <a href="{{ asset('storage/' . $salida->comprobante) }}" target="_blank"
                                    class="text-blue-600 underline">Ver</a>
                            @else
                                <span class="text-gray-400 italic">N/A</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
