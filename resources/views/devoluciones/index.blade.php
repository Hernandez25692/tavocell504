@extends('layouts.app')

@section('content')
    <div class="max-w-7xl mx-auto p-8 bg-gradient-to-br from-blue-50 via-white to-blue-100 shadow-2xl rounded-2xl mt-10 border border-blue-200">
        <div class="flex items-center gap-3 mb-8">
            <span class="text-3xl">📋</span>
            <h1 class="text-3xl font-extrabold text-blue-800 tracking-tight">Historial de Devoluciones</h1>
        </div>

        @if ($devoluciones->isEmpty())
            <div class="text-gray-500 text-center py-20 text-lg font-medium">
                No hay devoluciones registradas.
            </div>
        @else
            <div class="overflow-x-auto rounded-lg shadow-inner border border-blue-100 bg-white">
                <table class="min-w-full divide-y divide-blue-200">
                    <thead class="bg-blue-100">
                        <tr>
                            <th class="px-6 py-4 text-center text-blue-900 font-bold uppercase tracking-wider">Código Factura</th>
                            <th class="px-6 py-4 text-center text-blue-900 font-bold uppercase tracking-wider">Cliente</th>
                            <th class="px-6 py-4 text-center text-blue-900 font-bold uppercase tracking-wider">Usuario</th>
                            <th class="px-6 py-4 text-center text-blue-900 font-bold uppercase tracking-wider">Motivo</th>
                            <th class="px-6 py-4 text-center text-blue-900 font-bold uppercase tracking-wider">Total Devuelto</th>
                            <th class="px-6 py-4 text-center text-blue-900 font-bold uppercase tracking-wider">Fecha</th>
                            <th class="px-6 py-4 text-center text-blue-900 font-bold uppercase tracking-wider">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-blue-100">
                        @foreach ($devoluciones as $dev)
                            <tr class="hover:bg-blue-50 transition duration-150">
                                <td class="px-6 py-3 text-center font-mono text-blue-700">{{ $dev->factura->codigo }}</td>
                                <td class="px-6 py-3 text-center">{{ $dev->factura->cliente->nombre ?? '-' }}</td>
                                <td class="px-6 py-3 text-center">{{ $dev->usuario->name }}</td>
                                <td class="px-6 py-3 text-center text-gray-700">{{ $dev->motivo }}</td>
                                <td class="px-6 py-3 text-center font-semibold text-green-700">L. {{ number_format($dev->total, 2) }}</td>
                                <td class="px-6 py-3 text-center text-gray-500">{{ $dev->created_at->format('d/m/Y H:i') }}</td>
                                <td class="px-6 py-3 text-center">
                                    @if(isset($dev->pdf_url))
                                        <a href="{{ $dev->pdf_url }}" target="_blank" class="inline-flex items-center gap-2 text-red-600 hover:text-red-800 font-semibold transition" title="Descargar PDF">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                            </svg>
                                            <span>PDF</span>
                                        </a>
                                    @else
                                        <a href="{{ route('devoluciones.show', $dev->id) }}"
                                            class="inline-flex items-center gap-2 text-indigo-600 hover:text-indigo-900 font-semibold transition">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2a2 2 0 012-2h2a2 2 0 012 2v2m-6 4h6a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                            <span>Ver Comprobante</span>
                                        </a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-8 flex justify-center">
                {{ $devoluciones->links() }}
            </div>
        @endif

        <div class="flex justify-end">
            <a href="{{ url()->previous() }}"
                class="inline-flex items-center gap-2 mt-8 px-6 py-3 bg-blue-700 text-white rounded-lg hover:bg-blue-900 transition font-bold shadow-lg">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
                Regresar
            </a>
        </div>
    </div>
@endsection
