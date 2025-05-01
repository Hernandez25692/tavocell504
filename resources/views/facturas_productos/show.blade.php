@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-8 animate-fade-in">
        <div class="max-w-5xl mx-auto space-y-8">
            <h1 class="text-3xl font-bold text-gray-800 mb-6">🧾 Factura Producto
                {{ $factura->codigo ?? 'PROD-' . str_pad($factura->id, 5, '0', STR_PAD_LEFT) }}</h1>


            <!-- Información general -->
            <div class="bg-white shadow-md rounded-lg p-6 border border-gray-200">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-gray-700">
                    <p><strong>👤 Cliente:</strong> {{ optional($factura->cliente)->nombre ?? 'Consumidor Final' }}</p>
                    <p><strong>🧑‍💼 Vendedor:</strong> {{ $factura->usuario->name ?? 'No registrado' }}</p>
                    <p><strong>📅 Fecha:</strong>
                        {{ $factura->created_at ? $factura->created_at->format('Y-m-d H:i') : 'No disponible' }}</p>
                    <p><strong>💳 Método de Pago:</strong>
                        <span class="inline-block px-2 py-1 rounded bg-blue-100 text-blue-700 font-medium">
                            {{ $factura->metodo_pago }}
                        </span>
                    </p>
                    <p><strong>💰 Subtotal:</strong> L. {{ number_format($factura->subtotal, 2) }}</p>
                    <p><strong>💵 Total:</strong>
                        <span class="font-bold text-green-700 text-lg">L. {{ number_format($factura->total, 2) }}</span>
                    </p>
                </div>
            </div>

            <!-- Detalle de productos -->
            <div>
                <h2 class="text-xl font-semibold text-gray-800 mb-4 mt-2">📦 Productos Facturados</h2>
                <div class="overflow-x-auto bg-white rounded-lg shadow border border-gray-200">
                    <table class="min-w-full table-auto text-sm text-left">
                        <thead class="bg-gray-100 text-gray-700 uppercase text-xs font-semibold">
                            <tr>
                                <th class="px-6 py-3">Producto</th>
                                <th class="px-6 py-3">Cantidad</th>
                                <th class="px-6 py-3">Precio Unitario</th>
                                <th class="px-6 py-3">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-700">
                            @foreach ($factura->detalles as $detalle)
                                @if ($detalle->producto_id)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4">{{ $detalle->producto->nombre }}</td>
                                        <td class="px-6 py-4">{{ $detalle->cantidad }}</td>
                                        <td class="px-6 py-4">L. {{ number_format($detalle->precio_unitario, 2) }}</td>
                                        <td class="px-6 py-4 font-medium text-green-700">L.
                                            {{ number_format($detalle->subtotal, 2) }}</td>
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Acciones -->
            <div class="flex flex-wrap gap-4 justify-between items-center mt-6">
                <a href="{{ route('facturas_productos.pdf', ['factura' => $factura->id, 'copia' => 1]) }}" target="_blank"
                    class="btn btn-sm bg-blue-600 text-white hover:bg-blue-700">
                    📄 Reimprimir PDF
                </a>
                @if (!$factura->impresa)
                    <a href="{{ route('facturas_productos.pdf', ['factura' => $factura->id]) }}" target="_blank"
                        class="btn btn-sm bg-green-600 text-white hover:bg-green-700">
                        🖨️ Imprimir Original
                    </a>
                @else
                    <button class="btn btn-sm bg-gray-400 text-white cursor-not-allowed" disabled>
                        🖨️ Original Impresa
                    </button>
                @endif

                <a href="{{ route('facturas_productos.index') }}"
                    class="inline-flex items-center gap-2 bg-gray-200 hover:bg-gray-300 text-gray-800 font-medium px-4 py-2 rounded-lg transition">
                    ← Volver al Historial
                </a>
            </div>
        </div>
    </div>

    @push('styles')
        <style>
            .animate-fade-in {
                animation: fadeIn 0.5s ease-out;
            }

            @keyframes fadeIn {
                from {
                    opacity: 0;
                    transform: translateY(10px);
                }

                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }
        </style>
    @endpush
@endsection
