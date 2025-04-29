@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-blue-50 py-8 px-6 animate-fade-in">
    <div class="max-w-7xl mx-auto space-y-8">
        <!-- Título y Filtros -->
        <div class="bg-white p-6 rounded-xl shadow-md">
            <h1 class="text-2xl font-bold text-gray-800 mb-4 flex items-center gap-2">
                💰 Reporte de Utilidades
            </h1>
            <form method="GET" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4">
                <div>
                    <label class="text-sm text-gray-600">Desde</label>
                    <input type="date" name="desde" value="{{ $desde }}"
                        class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-indigo-500 focus:border-indigo-500 shadow-sm">
                </div>
                <div>
                    <label class="text-sm text-gray-600">Hasta</label>
                    <input type="date" name="hasta" value="{{ $hasta }}"
                        class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-indigo-500 focus:border-indigo-500 shadow-sm">
                </div>
                <div class="sm:col-span-2 flex items-end gap-3">
                    <button type="submit"
                        class="bg-indigo-600 text-white font-medium px-5 py-2 rounded-md shadow-md hover:bg-indigo-700 transition">
                        Aplicar filtro
                    </button>
                    <a href="{{ route('utilidades.index') }}"
                        class="bg-gray-200 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-300 transition">
                        Limpiar
                    </a>
                </div>
            </form>
        </div>

        <!-- Resumen Global -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-green-100 p-4 rounded-xl shadow flex justify-between items-center">
                <div>
                    <p class="text-sm text-green-800 font-semibold">Ganancia en Reparaciones</p>
                    <p class="text-xl font-bold text-green-900">L. {{ number_format($gananciaReparaciones, 2) }}</p>
                </div>
                <svg class="h-8 w-8 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13 16h-1v-4h-1m1-4h.01M12 2a10 10 0 110 20 10 10 0 010-20z" />
                </svg>
            </div>
            <div class="bg-blue-100 p-4 rounded-xl shadow flex justify-between items-center">
                <div>
                    <p class="text-sm text-blue-800 font-semibold">Ganancia en Productos</p>
                    <p class="text-xl font-bold text-blue-900">L. {{ number_format($gananciaProductos, 2) }}</p>
                </div>
                <svg class="h-8 w-8 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M5 13l4 4L19 7" />
                </svg>
            </div>
            <div class="bg-yellow-100 p-4 rounded-xl shadow flex justify-between items-center">
                <div>
                    <p class="text-sm text-yellow-800 font-semibold">Ganancia Total</p>
                    <p class="text-xl font-bold text-yellow-900">L. {{ number_format($gananciaTotal, 2) }}</p>
                </div>
                <svg class="h-8 w-8 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
        </div>

        <!-- Tabla Reparaciones -->
        <div class="bg-white rounded-xl shadow p-6">
            <h2 class="text-lg font-bold text-gray-800 mb-4">Utilidad en Reparaciones</h2>
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm table-auto divide-y divide-gray-200">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-4 py-2 text-left">Código</th>
                            <th class="px-4 py-2 text-left">Cliente</th>
                            <th class="px-4 py-2 text-left">Total Cliente</th>
                            <th class="px-4 py-2 text-left">Costo Tavocell</th>
                            <th class="px-4 py-2 text-left">Ganancia</th>
                            <th class="px-4 py-2 text-left">Fecha</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($reparaciones as $rep)
                            <tr>
                                <td class="px-4 py-2">#{{ $rep['codigo'] }}</td>
                                <td class="px-4 py-2">{{ $rep['cliente'] }}</td>
                                <td class="px-4 py-2">L. {{ number_format($rep['total'], 2) }}</td>
                                <td class="px-4 py-2">L. {{ number_format($rep['costo_tavocell'], 2) }}</td>
                                <td class="px-4 py-2 font-semibold text-green-700">L. {{ number_format($rep['ganancia'], 2) }}</td>
                                <td class="px-4 py-2 text-sm text-gray-600">{{ $rep['fecha'] }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="6" class="text-center py-3 text-gray-500">No hay datos</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Tabla Productos -->
        <div class="bg-white rounded-xl shadow p-6">
            <h2 class="text-lg font-bold text-gray-800 mb-4">Utilidad en Ventas de Productos</h2>
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm table-auto divide-y divide-gray-200">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-4 py-2 text-left">Producto</th>
                            <th class="px-4 py-2 text-left">Cantidad</th>
                            <th class="px-4 py-2 text-left">Ingreso/Venta</th>
                            <th class="px-4 py-2 text-left">Costo Compra</th>
                            <th class="px-4 py-2 text-left">Ganancia</th>
                            <th class="px-4 py-2 text-left">Fecha</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($productos as $prod)
                            <tr>
                                <td class="px-4 py-2">{{ $prod['producto'] }}</td>
                                <td class="px-4 py-2">{{ $prod['cantidad'] }}</td>
                                <td class="px-4 py-2">L. {{ number_format($prod['venta'], 2) }}</td>
                                <td class="px-4 py-2">L. {{ number_format($prod['compra'], 2) }}</td>
                                <td class="px-4 py-2 font-semibold text-blue-700">L. {{ number_format($prod['ganancia'], 2) }}</td>
                                <td class="px-4 py-2 text-sm text-gray-600">{{ $prod['fecha'] }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="6" class="text-center py-3 text-gray-500">No hay datos</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
