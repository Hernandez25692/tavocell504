@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-2xl mx-auto bg-white shadow-xl rounded-xl p-8 border border-gray-200">
            <h1 class="text-3xl font-extrabold text-gray-800 mb-6 flex items-center gap-2">
                ✏️ Editar Producto
            </h1>

            @if ($errors->any())
                <div class="mb-4 p-4 bg-red-100 text-red-700 rounded-lg shadow">
                    <strong>Oops!</strong> Corrige los siguientes errores:
                    <ul class="list-disc list-inside mt-2">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('productos.update', $producto) }}" class="space-y-6">
                @csrf
                @method('PUT')

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nombre</label>
                    <input type="text" name="nombre" value="{{ old('nombre', $producto->nombre) }}" required
                        class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Código</label>
                    <input type="text" name="codigo" value="{{ old('codigo', $producto->codigo) }}" required
                        class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Descripción</label>
                    <textarea name="descripcion" rows="3"
                        class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:outline-none">{{ old('descripcion', $producto->descripcion) }}</textarea>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Stock</label>
                        <input type="number" name="stock" value="{{ old('stock', $producto->stock) }}" required
                            class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Proveedor</label>
                        <input type="text" name="proveedor" value="{{ old('proveedor', $producto->proveedor) }}"
                            class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Precio de compra (L.)</label>
                        <input type="number" step="0.01" name="precio_compra"
                            value="{{ old('precio_compra', $producto->precio_compra) }}" required
                            class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Precio de venta (L.)</label>
                        <input type="number" step="0.01" name="precio_venta"
                            value="{{ old('precio_venta', $producto->precio_venta) }}" required
                            class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                    </div>
                </div>

                <!-- Checkbox ¿Es Celular? -->
                <div>
                    <input type="hidden" name="es_celular" value="0">
                    <label class="inline-flex items-center mt-1">
                        <input type="checkbox" id="es_celular" name="es_celular" value="1"
                            {{ old('es_celular', $producto->es_celular) ? 'checked' : '' }}
                            class="form-checkbox h-5 w-5 text-indigo-600">
                        <span class="ml-2 text-sm text-gray-700">Este producto es un celular</span>
                    </label>
                </div>

                <!-- Campos adicionales si es celular -->
                <div id="campos_celular" class="space-y-4 {{ old('es_celular', $producto->es_celular) ? '' : 'hidden' }}">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">IMEI</label>
                            <input type="text" name="imei" value="{{ old('imei', $producto->imei) }}"
                                class="w-full border-gray-300 rounded-md shadow-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Color</label>
                            <input type="text" name="color" value="{{ old('color', $producto->color) }}"
                                class="w-full border-gray-300 rounded-md shadow-sm">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">RAM</label>
                            <input type="text" name="ram" value="{{ old('ram', $producto->ram) }}"
                                class="w-full border-gray-300 rounded-md shadow-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Almacenamiento</label>
                            <input type="text" name="almacenamiento"
                                value="{{ old('almacenamiento', $producto->almacenamiento) }}"
                                class="w-full border-gray-300 rounded-md shadow-sm">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Marca</label>
                            <input type="text" name="marca" value="{{ old('marca', $producto->marca) }}"
                                class="w-full border-gray-300 rounded-md shadow-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Modelo</label>
                            <input type="text" name="modelo" value="{{ old('modelo', $producto->modelo) }}"
                                class="w-full border-gray-300 rounded-md shadow-sm">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Sistema Operativo</label>
                        <input type="text" name="sistema_operativo"
                            value="{{ old('sistema_operativo', $producto->sistema_operativo) }}"
                            class="w-full border-gray-300 rounded-md shadow-sm">
                    </div>
                </div>

                <div class="text-end">
                    <button type="submit"
                        class="inline-flex items-center gap-2 bg-green-600 hover:bg-green-700 text-white font-semibold px-6 py-2 rounded-lg shadow transition-all">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        Actualizar Producto
                    </button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const checkbox = document.getElementById('es_celular');
                const camposCelular = document.getElementById('campos_celular');

                function toggleCampos() {
                    camposCelular.classList.toggle('hidden', !checkbox.checked);
                }

                checkbox.addEventListener('change', toggleCampos);
                toggleCampos(); // Ejecutar al cargar por si ya está marcado
            });
        </script>
    @endpush
@endsection
