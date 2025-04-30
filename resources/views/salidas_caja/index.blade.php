@extends('layouts.app')

@section('content')
    <div class="max-w-6xl mx-auto py-10 px-4">
        <div class="mb-6 flex flex-col md:flex-row justify-between items-center gap-4">
            <h2 class="text-2xl font-bold text-gray-800">📤 Salidas de Caja</h2>

            <a href="{{ route('salidas-caja.create') }}"
                class="inline-block bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-5 py-2 rounded shadow transition">
                + Nueva
            </a>
        </div>

        <!-- Filtros -->
        <form method="GET" action="{{ route('salidas-caja.index') }}"
            class="mb-6 grid grid-cols-1 md:grid-cols-4 gap-4 items-end">

            <div>
                <label class="block text-sm font-medium text-gray-700">Buscar (usuario o motivo)</label>
                <input type="text" name="buscar" value="{{ request('buscar') }}" placeholder="Buscar..."
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Desde</label>
                <input type="date" name="desde" value="{{ request('desde') }}"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Hasta</label>
                <input type="date" name="hasta" value="{{ request('hasta') }}"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
            </div>

            <div class="flex gap-2">
                <button type="submit"
                    class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md shadow-md w-full">
                    🔍 Filtrar
                </button>
                <a href="{{ route('salidas-caja.index') }}"
                    class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded-md shadow-md w-full text-center">
                    Limpiar
                </a>
            </div>
        </form>

        <!-- Tabla -->
        <div class="bg-white shadow rounded overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="bg-gray-100 text-left text-gray-700 uppercase text-xs">
                    <tr>
                        <th class="px-4 py-3">Fecha</th>
                        <th class="px-4 py-3">Usuario</th>
                        <th class="px-4 py-3">Monto</th>
                        <th class="px-4 py-3">Motivo</th>
                        <th class="px-4 py-3">Comprobante</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($salidas as $salida)
                        <tr class="border-t hover:bg-gray-50">
                            <td class="px-4 py-3">{{ $salida->created_at->format('Y-m-d H:i') }}</td>
                            <td class="px-4 py-3">{{ $salida->usuario->name }}</td>
                            <td class="px-4 py-3 font-semibold text-red-600">L. {{ number_format($salida->monto, 2) }}</td>
                            <td class="px-4 py-3">{{ $salida->motivo }}</td>
                            <td class="px-4 py-3">
                                @if ($salida->comprobante)
                                    <a href="{{ asset('storage/' . $salida->comprobante) }}" target="_blank"
                                        class="text-blue-600 underline">Ver</a>
                                @else
                                    <span class="text-gray-400 italic">N/A</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-4 text-center text-gray-500">No hay registros encontrados.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Paginación -->
        <div class="mt-6">
            {{ $salidas->appends(request()->query())->links() }}
        </div>
    </div>
@endsection
