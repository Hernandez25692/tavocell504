@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-6">🔧 Historial de Facturas de Reparación</h1>

        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-800 px-4 py-3 rounded mb-4">
                ✅ {{ session('success') }}
            </div>
        @endif
        <form method="GET" action="{{ route('facturas_reparaciones.index') }}" class="mb-6 flex gap-3">
            <input type="text" name="codigo" value="{{ request('codigo') }}"
                placeholder="Buscar por código (REP-00001) o ID"
                class="border border-gray-300 rounded-md px-4 py-2 shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 text-sm w-64">

            <button type="submit"
                class="bg-indigo-600 hover:bg-indigo-700 text-white font-medium px-4 py-2 rounded shadow-sm text-sm">
                🔍 Buscar
            </button>

            @if (request('codigo'))
                <a href="{{ route('facturas_reparaciones.index') }}"
                    class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-4 py-2 rounded text-sm shadow">
                    ✖ Limpiar
                </a>
            @endif
        </form>

        <div class="overflow-x-auto bg-white rounded-lg shadow border border-gray-200">
            <table class="min-w-full table-auto text-sm text-left">
                <thead class="bg-gray-100 text-gray-700 uppercase text-xs font-semibold">
                    <tr>
                        <th class="px-6 py-3">ID</th>
                        <th class="px-6 py-3">Fecha</th>
                        <th class="px-6 py-3">Cliente</th>
                        <th class="px-6 py-3">Descripción</th>
                        <th class="px-6 py-3">Costo Total</th>
                        <th class="px-6 py-3 text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($facturas as $factura)
                        @php
                            $reparacion = $reparaciones[$factura->id] ?? null;
                        @endphp
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 text-indigo-600 font-semibold">
                                REP-{{ str_pad($factura->id, 5, '0', STR_PAD_LEFT) }}
                            </td>

                            <td class="px-6 py-4">{{ $factura->created_at->format('Y-m-d H:i') }}</td>
                            <td class="px-6 py-4">{{ $factura->cliente->nombre ?? 'Consumidor Final' }}</td>
                            <td class="px-6 py-4">{{ $factura->detalles->first()->descripcion ?? 'Servicio de reparación' }}
                            </td>
                            <td class="px-6 py-4 font-bold text-green-700">
                                L. {{ number_format($reparacion->costo_total ?? 0, 2) }}
                            </td>
                            <td class="px-6 py-4 text-center flex gap-2 justify-center">
                                <a href="{{ route('facturas_reparaciones.show', $factura->id) }}"
                                    class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded text-sm">Ver</a>
                                <a href="{{ route('facturas_reparaciones.pdf', $factura->id) }}"
                                    class="bg-gray-600 hover:bg-gray-700 text-white px-3 py-1 rounded text-sm">PDF</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
