@extends('layouts.app')

@section('content')
    <div class="flex items-center justify-center min-h-screen bg-gray-50 py-8 px-2">
        <div class="w-full max-w-3xl bg-white rounded-2xl shadow-lg p-6 md:p-10">
            <div class="flex items-center gap-3 mb-6">
                <span class="text-3xl md:text-4xl">↩️</span>
                <h1 class="text-2xl md:text-3xl font-bold text-gray-800">
                    Seleccionar productos para devolución <br>
                    <span class="ml-2 px-3 py-1 bg-red-100 text-red-700 rounded-lg text-base font-semibold">
                        Factura {{ $factura->codigo }}
                    </span>
                </h1>
            </div>

            <form action="{{ route('devoluciones.procesar') }}" method="POST" id="devolucionForm" autocomplete="off">
                @csrf
                <input type="hidden" name="factura_id" value="{{ $factura->id }}">

                <div class="mb-6">
                    <label class="block font-semibold text-gray-700 mb-2">
                        Motivo de devolución <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <textarea name="motivo" required maxlength="255"
                            class="w-full border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-red-400 focus:border-red-400 transition p-3 pr-16 resize-none text-gray-800"
                            rows="3" id="motivoTextarea"></textarea>
                        <span id="charCount"
                            class="absolute bottom-2 right-3 text-xs text-gray-400 select-none">0/255</span>
                    </div>
                </div>

                <div class="flex items-center mb-4">
                    <input type="checkbox" id="select-all" class="mr-2 accent-red-600 w-5 h-5">
                    <label for="select-all" class="font-medium text-gray-700 cursor-pointer select-none">
                        Seleccionar todos los productos
                    </label>
                </div>

                <div class="overflow-x-auto rounded-lg shadow-sm mb-6">
                    <table class="min-w-full bg-white text-sm md:text-base">
                        <thead>
                            <tr class="bg-gray-100 text-gray-700">
                                <th class="px-3 py-2 text-center"></th>
                                <th class="px-3 py-2 text-left">Código</th>
                                <th class="px-3 py-2 text-left">Producto</th>
                                <th class="px-3 py-2 text-center">Cantidad</th>
                                <th class="px-3 py-2 text-center">Precio Unitario</th>
                                <th class="px-3 py-2 text-center">Cantidad a devolver</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($factura->detalles as $detalle)
                                <tr class="border-t hover:bg-gray-50 transition">
                                    <td class="px-3 py-2 text-center">
                                        <input type="checkbox" name="checks[]" value="{{ $detalle->id }}"
                                            class="producto-check accent-red-600 w-5 h-5"
                                            data-input="input-{{ $detalle->id }}">
                                    </td>
                                    <td class="px-3 py-2">
                                        <span class="text-xs font-semibold text-indigo-600">
                                            {{ $detalle->producto->codigo ?? 'N/A' }}
                                        </span>
                                    </td>
                                    <td class="px-3 py-2">
                                        <span class="font-medium text-gray-800">{{ $detalle->producto->nombre }}</span>
                                    </td>
                                    <td class="px-3 py-2 text-center">
                                        {{ $detalle->cantidad }}
                                    </td>
                                    <td class="px-3 py-2 text-center">
                                        <span class="text-gray-700">L.
                                            {{ number_format($detalle->precio_unitario, 2) }}</span>
                                    </td>
                                    <td class="px-3 py-2 text-center">
                                        <input type="number" id="input-{{ $detalle->id }}"
                                            name="productos[{{ $detalle->id }}]"
                                            class="cantidad-input w-20 md:w-24 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-red-400 focus:border-red-400 transition text-center disabled:bg-gray-100"
                                            min="0" max="{{ $detalle->cantidad }}" step="1" disabled
                                            autocomplete="off">
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>

                <div class="flex justify-center mt-8">
                    <button type="submit"
                        class="flex items-center gap-2 bg-red-600 hover:bg-red-700 text-white font-bold px-8 py-3 rounded-xl shadow-lg text-lg transition focus:outline-none focus:ring-2 focus:ring-red-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 17v-2a4 4 0 014-4h7m0 0l-3-3m3 3l-3 3" />
                        </svg>
                        Procesar Devolución
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Scripts --}}
    <script>
        // Motivo textarea character counter
        const motivoTextarea = document.getElementById('motivoTextarea');
        const charCount = document.getElementById('charCount');
        motivoTextarea.addEventListener('input', function() {
            charCount.textContent = `${this.value.length}/255`;
        });

        // Checkbox logic
        const selectAll = document.getElementById('select-all');
        const productoChecks = document.querySelectorAll('.producto-check');
        const cantidadInputs = document.querySelectorAll('.cantidad-input');

        selectAll.addEventListener('change', function() {
            productoChecks.forEach((checkbox, idx) => {
                checkbox.checked = this.checked;
                const input = document.getElementById(checkbox.dataset.input);
                input.disabled = !this.checked;
                if (this.checked) {
                    input.value = input.max;
                    input.classList.remove('border-red-500', 'ring-2', 'ring-red-400');
                } else {
                    input.value = '';
                    input.classList.remove('border-red-500', 'ring-2', 'ring-red-400');
                }
            });
        });

        productoChecks.forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                const input = document.getElementById(this.dataset.input);
                input.disabled = !this.checked;
                if (this.checked) {
                    input.value = input.max;
                    input.classList.remove('border-red-500', 'ring-2', 'ring-red-400');
                } else {
                    input.value = '';
                    input.classList.remove('border-red-500', 'ring-2', 'ring-red-400');
                }
                // If any is unchecked, uncheck select-all
                if (!this.checked) selectAll.checked = false;
                // If all are checked, check select-all
                if ([...productoChecks].every(cb => cb.checked)) selectAll.checked = true;
            });
        });

        // Validación visual y lógica
        cantidadInputs.forEach(input => {
            input.addEventListener('input', function() {
                const max = parseInt(this.max);
                const val = parseInt(this.value || 0);
                if (val > max || val < 0) {
                    this.classList.add('border-red-500', 'ring-2', 'ring-red-400');
                } else {
                    this.classList.remove('border-red-500', 'ring-2', 'ring-red-400');
                }
            });
        });

        document.getElementById('devolucionForm').addEventListener('submit', function(e) {
            let isValid = true;
            cantidadInputs.forEach(input => {
                if (!input.disabled) {
                    const max = parseInt(input.max);
                    const val = parseInt(input.value || 0);
                    if (val > max || val < 0) {
                        input.classList.add('border-red-500', 'ring-2', 'ring-red-400');
                        isValid = false;
                    } else {
                        input.classList.remove('border-red-500', 'ring-2', 'ring-red-400');
                    }
                }
            });
            if (!isValid) {
                e.preventDefault();
                alert('⚠️ No puedes devolver más de la cantidad facturada ni valores negativos.');
            }
        });
    </script>
@endsection
