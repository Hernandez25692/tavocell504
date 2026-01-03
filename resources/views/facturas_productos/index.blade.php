@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-8 space-y-6">

        <h1 class="text-3xl font-bold text-gray-800">🧾 Historial de Facturas de Productos</h1>

        {{-- RESUMEN --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="bg-white border rounded-lg p-4 shadow">
                <p class="text-sm text-gray-500">Total de Facturas</p>
                <p class="text-2xl font-bold text-indigo-600">{{ $totalFacturas }}</p>
            </div>
            <div class="bg-white border rounded-lg p-4 shadow">
                <p class="text-sm text-gray-500">Total Vendido</p>
                <p class="text-2xl font-bold text-green-600">
                    L. {{ number_format($totalVentas, 2) }}
                </p>
            </div>
        </div>

        {{-- FILTROS --}}
        <form method="GET" action="{{ route('facturas_productos.index') }}"
            class="bg-white p-4 rounded-lg shadow border grid grid-cols-1 md:grid-cols-8 gap-4 text-sm">

            <input type="text" name="codigo" value="{{ request('codigo') }}" placeholder="PROD-00012 / ID"
            class="border rounded px-3 py-2">

            <input type="text" name="cliente" value="{{ request('cliente') }}" placeholder="Cliente"
            class="border rounded px-3 py-2">

            <input type="text" name="usuario" value="{{ request('usuario') }}" placeholder="Usuario"
            class="border rounded px-3 py-2">

            <input type="date" name="desde" value="{{ request('desde') ?? now()->format('Y-m-d') }}" class="border rounded px-3 py-2">

            <input type="date" name="hasta" value="{{ request('hasta') ?? now()->format('Y-m-d') }}" class="border rounded px-3 py-2">

            <select name="devolucion" class="border rounded px-3 py-2">
            <option value="">Devoluciones</option>
            <option value="si" {{ request('devolucion') == 'si' ? 'selected' : '' }}>Con devolución</option>
            <option value="no" {{ request('devolucion') == 'no' ? 'selected' : '' }}>Sin devolución</option>
            </select>

            <div class="flex gap-2">
            <button class="bg-indigo-600 text-white px-4 py-2 rounded">
                Filtrar
            </button>
            <a href="{{ route('facturas_productos.index') }}" class="bg-gray-300 px-4 py-2 rounded">
                Limpiar
            </a>
            </div>
        </form>

        {{-- TABLA --}}
        <div class="overflow-x-auto bg-white rounded-lg shadow border">
            <table class="min-w-full text-sm">
                <thead class="bg-gray-100 uppercase text-xs">
                    <tr>
                        <th class="px-6 py-3">Código</th>
                        <th class="px-6 py-3">Fecha</th>
                        <th class="px-6 py-3">Cliente</th>
                        <th class="px-6 py-3 text-right">Total</th>
                        <th class="px-6 py-3 text-center">Estado</th>
                        <th class="px-6 py-3 text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @php $subtotal = 0; @endphp

                    @forelse ($facturas as $factura)
                        @php $subtotal += $factura->total; @endphp
                        <tr class="border-t hover:bg-gray-50">
                            <td class="px-6 py-3 font-semibold text-indigo-600">
                                {{ $factura->codigo ?? 'PROD-' . str_pad($factura->id, 5, '0', STR_PAD_LEFT) }}
                            </td>
                            <td class="px-6 py-3">{{ $factura->created_at->format('d/m/Y H:i') }}</td>
                            <td class="px-6 py-3">{{ $factura->cliente->nombre ?? 'Consumidor Final' }}</td>
                            <td class="px-6 py-3 text-right font-bold text-green-700">
                                L. {{ number_format($factura->total, 2) }}
                            </td>
                            <td class="px-6 py-3 text-center">
                                @if ($factura->devoluciones->isNotEmpty())
                                    <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-xs">
                                        ⚠ Con devolución
                                    </span>
                                @else
                                    <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs">
                                        ✔ Sin devolución
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-3 text-center space-x-2">
                                <a href="{{ route('facturas_productos.show', $factura->id) }}"
                                    class="bg-blue-600 text-white px-3 py-1 rounded text-xs">Ver</a>
                                <a href="{{ route('facturas_productos.pdf', $factura->id) }}"
                                    class="bg-gray-700 text-white px-3 py-1 rounded text-xs">PDF</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                                No hay facturas registradas.
                            </td>
                        </tr>
                    @endforelse
                </tbody>

                {{-- TOTALES PÁGINA --}}
                <tfoot class="bg-gray-100 border-t">
                    <tr>
                        <td colspan="3" class="px-6 py-3 text-right font-bold">
                            TOTAL PÁGINA
                        </td>
                        <td class="px-6 py-3 text-right font-bold text-green-700">
                            L. {{ number_format($subtotal, 2) }}
                        </td>
                        <td colspan="2"></td>
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
