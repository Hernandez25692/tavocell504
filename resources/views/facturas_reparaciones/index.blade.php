@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-8 space-y-6">

        <h1 class="text-3xl font-bold text-gray-800">🔧 Historial de Facturas de Reparación</h1>

        {{-- RESUMEN --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="bg-white border rounded-lg p-4 shadow">
                <p class="text-sm text-gray-500">Total de Facturas</p>
                <p class="text-2xl font-bold text-indigo-600">{{ $totalFacturas }}</p>
            </div>
            <div class="bg-white border rounded-lg p-4 shadow">
                <p class="text-sm text-gray-500">Monto Total Reparaciones</p>
                <p class="text-2xl font-bold text-green-600">
                    L. {{ number_format($totalMonto, 2) }}
                </p>
            </div>
        </div>

        {{-- FILTROS --}}
        <form method="GET" action="{{ route('facturas_reparaciones.index') }}"
            class="bg-white p-4 rounded-lg shadow border grid grid-cols-1 md:grid-cols-6 gap-4 text-sm">

            <input type="text" name="codigo" value="{{ request('codigo') }}" placeholder="REP-00001 / ID"
            class="border rounded px-3 py-2">

            <input type="text" name="cliente" value="{{ request('cliente') }}" placeholder="Cliente"
            class="border rounded px-3 py-2">

            <input type="text" name="usuario" value="{{ request('usuario') }}" placeholder="Usuario"
            class="border rounded px-3 py-2">

            <input type="date" name="desde" value="{{ request('desde', now()->format('Y-m-d')) }}" class="border rounded px-3 py-2">

            <input type="date" name="hasta" value="{{ request('hasta', now()->format('Y-m-d')) }}" class="border rounded px-3 py-2">

            <div class="flex gap-2">
            <button class="bg-indigo-600 text-white px-4 py-2 rounded">
                Filtrar
            </button>
            <a href="{{ route('facturas_reparaciones.index') }}" class="bg-gray-300 px-4 py-2 rounded">
                Limpiar
            </a>
            </div>
        </form>

        {{-- TABLA --}}
        <div class="overflow-x-auto bg-white rounded-lg shadow border">
            <table class="min-w-full text-sm">
                <thead class="bg-gray-100 text-gray-700 uppercase text-xs">
                    <tr>
                        <th class="px-6 py-3">Código</th>
                        <th class="px-6 py-3">Fecha</th>
                        <th class="px-6 py-3">Cliente</th>
                        <th class="px-6 py-3">Descripción</th>
                        <th class="px-6 py-3 text-right">Costo</th>
                        <th class="px-6 py-3 text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @php $subtotal = 0; @endphp

                    @foreach ($facturas as $factura)
                        @php
                            $rep = $reparaciones[$factura->id] ?? null;
                            $monto = $rep->costo_total ?? 0;
                            $subtotal += $monto;
                        @endphp
                        <tr class="border-t hover:bg-gray-50">
                            <td class="px-6 py-3 font-semibold text-indigo-600">
                                REP-{{ str_pad($factura->id, 5, '0', STR_PAD_LEFT) }}
                            </td>
                            <td class="px-6 py-3">{{ $factura->created_at->format('d/m/Y H:i') }}</td>
                            <td class="px-6 py-3">{{ $factura->cliente->nombre ?? 'Consumidor Final' }}</td>
                            <td class="px-6 py-3">
                                {{ $factura->detalles->first()->descripcion ?? 'Servicio de reparación' }}
                            </td>
                            <td class="px-6 py-3 text-right font-bold text-green-700">
                                L. {{ number_format($monto, 2) }}
                            </td>
                            <td class="px-6 py-3 text-center space-x-2">
                                <a href="{{ route('facturas_reparaciones.show', $factura->id) }}"
                                    class="bg-blue-600 text-white px-3 py-1 rounded text-xs">Ver</a>
                                <a href="{{ route('facturas_reparaciones.pdf', $factura->id) }}"
                                    class="bg-gray-700 text-white px-3 py-1 rounded text-xs">PDF</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>

                {{-- TOTALES DE LA PÁGINA --}}
                <tfoot class="bg-gray-100 border-t">
                    <tr>
                        <td colspan="4" class="px-6 py-3 text-right font-bold">
                            TOTAL PÁGINA
                        </td>
                        <td class="px-6 py-3 text-right font-bold text-green-700">
                            L. {{ number_format($subtotal, 2) }}
                        </td>
                        <td></td>
                    </tr>
                </tfoot>
            </table>
        </div>

        {{-- PAGINACIÓN --}}
        <div>
            {{ $facturas->links() }}
        </div>

    </div>
@endsection
