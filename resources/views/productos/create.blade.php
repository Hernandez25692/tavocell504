@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-8 animate-fade-in">
        <div class="max-w-2xl mx-auto bg-white p-6 rounded-xl shadow-md space-y-6">
            <h1 class="text-2xl font-bold text-gray-800 flex items-center gap-2">
                ➕ Agregar Nuevo Producto
            </h1>

            <form method="POST" action="{{ route('productos.store') }}" class="space-y-5">
                @csrf

                <!-- Nombre -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nombre <span
                            class="text-red-500">*</span></label>
                    <input type="text" name="nombre" required
                        class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                </div>

                <!-- Código -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Código <span
                            class="text-red-500">*</span></label>
                    <input type="text" name="codigo" required
                        class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                </div>

                <!-- Descripción -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Descripción</label>
                    <textarea name="descripcion" rows="3"
                        class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"></textarea>
                </div>

                <!-- Stock -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Stock <span
                            class="text-red-500">*</span></label>
                    <input type="number" name="stock" required min="0"
                        class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                </div>

                <!-- Precio Compra y Venta -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Precio de Compra <span
                                class="text-red-500">*</span></label>
                        <input type="number" name="precio_compra" step="0.01" required
                            class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Precio de Venta <span
                                class="text-red-500">*</span></label>
                        <input type="number" name="precio_venta" step="0.01" required
                            class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                    </div>
                </div>

                <!-- Proveedor -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Proveedor</label>
                    <input type="text" name="proveedor"
                        class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                </div>
                <!-- Celular -->
                <div id="campos_celular" class="space-y-4 hidden">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">IMEI</label>
                            <input type="text" name="imei" class="w-full border-gray-300 rounded-md shadow-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Color</label>
                            <input type="text" name="color" class="w-full border-gray-300 rounded-md shadow-sm">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">RAM</label>
                            <input type="text" name="ram" class="w-full border-gray-300 rounded-md shadow-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Almacenamiento</label>
                            <input type="text" name="almacenamiento" class="w-full border-gray-300 rounded-md shadow-sm">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Marca</label>
                            <input type="text" name="marca" class="w-full border-gray-300 rounded-md shadow-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Modelo</label>
                            <input type="text" name="modelo" class="w-full border-gray-300 rounded-md shadow-sm">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Sistema Operativo</label>
                        <input type="text" name="sistema_operativo" class="w-full border-gray-300 rounded-md shadow-sm">
                    </div>
                </div>

                <!-- Botón -->
                <div class="pt-4">
                    <button type="submit"
                        class="w-full sm:w-auto bg-green-600 hover:bg-green-700 text-white font-semibold px-6 py-2 rounded-lg shadow-md transition">
                        Guardar Producto
                    </button>
                </div>
                <!-- ¿Es Celular? -->
                <div>
                    <!-- Campo oculto para que se envíe 0 si no se marca -->
                    <input type="hidden" name="es_celular" value="0">

                    <!-- Checkbox real -->
                    <label class="inline-flex items-center">
                        <input type="checkbox" id="es_celular" name="es_celular" value="1"
                            class="form-checkbox h-5 w-5 text-indigo-600">
                        <span class="ml-2 text-sm text-gray-700">Este producto es un celular</span>
                    </label>

                </div>

            </form>
        </div>
    </div>

    @push('styles')
        <style>
            .animate-fade-in {
                animation: fadeIn 0.4s ease-out;
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

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const checkbox = document.getElementById('es_celular');
                const campos = document.getElementById('campos_celular');

                checkbox.addEventListener('change', function() {
                    campos.classList.toggle('hidden', !this.checked);
                });
            });
        </script>
    @endpush
@endsection
