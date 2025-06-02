@extends('layouts.app')

@section('content')
    <div class="max-w-3xl mx-auto p-8 bg-gradient-to-br from-blue-50 via-white to-blue-100 shadow-2xl rounded-2xl mt-10 border border-blue-200">
        <div class="flex items-center mb-6">
            <div class="bg-blue-600 text-white rounded-full p-3 mr-4 shadow-lg">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2a4 4 0 014-4h3m4 4v6a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h6" />
                </svg>
            </div>
            <h2 class="text-3xl font-extrabold text-blue-800 tracking-tight">Comprobante de Devolución</h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <div>
                <p class="mb-2"><span class="font-semibold text-blue-700">Factura:</span> <span class="text-gray-700">{{ $devolucion->factura->codigo }}</span></p>
                <p class="mb-2"><span class="font-semibold text-blue-700">Cliente:</span> <span class="text-gray-700">{{ $devolucion->factura->cliente->nombre ?? 'Consumidor Final' }}</span></p>
                <p class="mb-2"><span class="font-semibold text-blue-700">Usuario:</span> <span class="text-gray-700">{{ $devolucion->usuario->name }}</span></p>
            </div>
            <div>
                <p class="mb-2"><span class="font-semibold text-blue-700">Fecha:</span> <span class="text-gray-700">{{ $devolucion->created_at->format('d/m/Y H:i') }}</span></p>
                <p class="mb-2"><span class="font-semibold text-blue-700">Motivo:</span> <span class="text-gray-700">{{ $devolucion->motivo }}</span></p>
            </div>
        </div>

        <div class="overflow-x-auto rounded-lg shadow">
            <table class="w-full text-sm border border-blue-200 bg-white">
                <thead class="bg-blue-100 text-blue-800">
                    <tr>
                        <th class="px-4 py-3 text-left font-semibold">Código</th>
                        <th class="px-4 py-3 text-left font-semibold">Producto</th>
                        <th class="px-4 py-3 text-center font-semibold">Cantidad</th>
                        <th class="px-4 py-3 text-center font-semibold">Precio</th>
                        <th class="px-4 py-3 text-center font-semibold">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($devolucion->detalles as $detalle)
                        <tr class="border-t border-blue-100 hover:bg-blue-50 transition">
                            <td class="px-4 py-2">{{ $detalle->producto->codigo ?? 'N/A' }}</td>
                            <td class="px-4 py-2">{{ $detalle->producto->nombre }}</td>
                            <td class="px-4 py-2 text-center">{{ $detalle->cantidad }}</td>
                            <td class="px-4 py-2 text-center">L. {{ number_format($detalle->precio_unitario, 2) }}</td>
                            <td class="px-4 py-2 text-center">L. {{ number_format($detalle->subtotal, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="flex justify-end mt-6">
            <div class="bg-blue-50 border border-blue-200 rounded-lg px-6 py-3 text-xl font-bold text-blue-800 shadow">
                Total Devuelto: <span class="text-blue-900">L. {{ number_format($devolucion->total, 2) }}</span>
            </div>
        </div>

        <div class="mt-8 flex justify-end">
            <a href="{{ route('devoluciones.index') }}"
                class="inline-flex items-center px-6 py-2 bg-blue-700 text-white rounded-lg shadow hover:bg-blue-800 transition font-semibold">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
                Regresar al Historial
            </a>
        </div>
    </div>
@endsection
