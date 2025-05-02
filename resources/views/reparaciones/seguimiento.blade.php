@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100">
    <div class="container mx-auto px-4 py-10 animate-fade-in">
        <!-- Notificaciones mejoradas -->
        @if (session('success'))
            <div class="bg-emerald-50 border-l-4 border-emerald-500 p-4 mb-6 rounded-lg shadow-sm flex items-start">
                <svg class="h-5 w-5 text-emerald-500 mr-3 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                <p class="text-sm font-medium text-emerald-800">
                    {{ session('success') }}
                </p>
            </div>
        @endif

        @if (session('error'))
            <div class="bg-rose-50 border-l-4 border-rose-500 p-4 mb-6 rounded-lg shadow-sm flex items-start">
                <svg class="h-5 w-5 text-rose-500 mr-3 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                </svg>
                <p class="text-sm font-medium text-rose-800">
                    {{ session('error') }}
                </p>
            </div>
        @endif

        <div class="max-w-5xl mx-auto space-y-6">

            <!-- Encabezado con efecto glassmorphism -->
            <div class="bg-white/90 backdrop-blur-sm p-6 rounded-2xl shadow-xl border border-white/20">
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-800 mb-2 flex items-center gap-3">
                            <span class="bg-indigo-100 p-3 rounded-xl text-indigo-600 shadow-inner">
                                <i class="fas fa-mobile-alt text-xl"></i>
                            </span>
                            <span class="bg-gradient-to-r from-indigo-600 to-blue-600 bg-clip-text text-transparent">
                                Seguimiento {{ $reparacion->factura?->codigo ?? 'REP-' . str_pad($reparacion->id, 5, '0', STR_PAD_LEFT) }}
                            </span>
                        </h1>
                    </div>
                    <div class="flex items-center gap-3">
                        <span class="px-3 py-1 rounded-full text-sm font-bold shadow-inner
                            { match ($reparacion->estado) {
                                'pendiente' => 'bg-red-100 text-red-800 animate-pulse',
                                'en_proceso' => 'bg-amber-100 text-amber-800',
                                'listo' => 'bg-emerald-100 text-emerald-800',
                                'entregado' => 'bg-blue-100 text-blue-800',
                                default => 'bg-gray-100 text-gray-800',
                            } }}">
                            <i class="fas 
                                { match ($reparacion->estado) {
                                    'pendiente' => 'fa-clock mr-1',
                                    'en_proceso' => 'fa-cogs mr-1',
                                    'listo' => 'fa-check-circle mr-1',
                                    'entregado' => 'fa-box-open mr-1',
                                    default => 'fa-question-circle mr-1',
                                }}"></i>
                            {{ ucfirst(str_replace('_', ' ', $reparacion->estado)) }}
                        </span>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                    <div class="space-y-3">
                        <div class="flex items-start gap-3 bg-gray-50/50 p-3 rounded-lg border border-gray-200/50">
                            <div class="bg-indigo-100 p-2 rounded-lg text-indigo-600 shadow-inner">
                                <i class="fas fa-user"></i>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-700">Cliente</h3>
                                <p class="text-gray-800 font-medium">{{ $reparacion->cliente->nombre }}</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-3 bg-gray-50/50 p-3 rounded-lg border border-gray-200/50">
                            <div class="bg-indigo-100 p-2 rounded-lg text-indigo-600 shadow-inner">
                                <i class="fas fa-mobile"></i>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-700">Dispositivo</h3>
                                <p class="text-gray-800 font-medium">{{ $reparacion->marca }} {{ $reparacion->modelo }}</p>
                                <p class="text-sm text-gray-600 mt-1"><span class="font-medium">Falla:</span> {{ $reparacion->falla_reportada ?? 'No registrado' }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-3">
                        <div class="flex items-start gap-3 bg-gray-50/50 p-3 rounded-lg border border-gray-200/50">
                            <div class="bg-indigo-100 p-2 rounded-lg text-indigo-600 shadow-inner">
                                <i class="fas fa-file-invoice-dollar"></i>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-700">Financiero</h3>
                                <p class="text-gray-800"><span class="font-medium">Costo:</span> L. {{ number_format($reparacion->costo_total, 2) }}</p>
                                <p class="text-gray-800"><span class="font-medium">Abonado:</span> L. {{ number_format($reparacion->abono, 2) }}</p>
                                @php $pendiente = $reparacion->costo_total - $reparacion->abono; @endphp
                                @if($pendiente > 0)
                                    <p class="text-red-600 font-medium"><span class="font-medium">Pendiente:</span> L. {{ number_format($pendiente, 2) }}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Formulario de avance técnico -->
            <div class="bg-white/90 backdrop-blur-sm p-6 rounded-2xl shadow-xl border border-white/20">
                <h2 class="text-2xl font-bold text-gray-800 mb-6 flex items-center gap-3">
                    <span class="bg-blue-100 p-2 rounded-xl text-blue-600 shadow-inner">
                        <i class="fas fa-plus-circle"></i>
                    </span>
                    <span class="bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent">
                        Nuevo Avance Técnico
                    </span>
                </h2>

                <form action="{{ route('seguimientos.store', $reparacion) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Descripción del avance *</label>
                        <textarea name="descripcion" required rows="4"
                            class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-indigo-200 focus:border-indigo-500 shadow-sm transition duration-200 focus:shadow-md"
                            placeholder="Describa en detalle el avance realizado..."></textarea>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Estado actual *</label>
                            <select name="estado" required
                                class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-indigo-200 focus:border-indigo-500 shadow-sm transition duration-200 bg-white">
                                <option value="recibido">Recibido</option>
                                <option value="en_proceso">En proceso</option>
                                <option value="listo">Listo para entrega</option>
                                <option value="entregado">Entregado</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Evidencia fotográfica</label>
                            <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-dashed border-gray-300 rounded-xl hover:border-indigo-400 transition duration-200">
                                <div class="space-y-1 text-center">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                        <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                    <div class="flex justify-center text-sm text-gray-600">
                                        <label for="imagenesInput" class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none">
                                            <span>Subir imágenes</span>
                                            <input id="imagenesInput" name="imagenes[]" type="file" multiple accept="image/*" class="sr-only">
                                        </label>
                                        <p class="pl-1">o arrastrar aquí</p>
                                    </div>
                                    <p class="text-xs text-gray-500">PNG, JPG, GIF hasta 5MB</p>
                                </div>
                            </div>
                            
                            <!-- Vista previa de imágenes -->
                            <div id="previewContainer" class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-4 hidden">
                                <!-- Las imágenes se agregarán dinámicamente aquí -->
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-end">
                        <button type="submit"
                            class="flex items-center gap-2 bg-gradient-to-r from-indigo-600 to-blue-600 hover:from-indigo-700 hover:to-blue-700 text-white px-6 py-3 rounded-xl font-semibold shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-0.5 active:translate-y-0">
                            <i class="fas fa-save"></i>
                            Guardar Avance
                        </button>
                    </div>
                </form>
            </div>

            <!-- Sección de pagos pendientes -->
            @if ($pendiente > 0 && !$reparacion->factura_id)
                <div class="bg-amber-50/90 border-l-4 border-amber-500 p-6 rounded-2xl shadow-xl">
                    <div class="flex items-start gap-4">
                        <div class="bg-amber-100 p-3 rounded-xl text-amber-600 shadow-inner">
                            <i class="fas fa-exclamation-triangle text-xl"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-gray-800 mb-2">Saldo pendiente de pago</h3>
                            <p class="text-gray-700 mb-4">
                                El cliente aún debe <span class="font-bold text-red-600">L. {{ number_format($pendiente, 2) }}</span>.
                                Debe pagar la totalidad antes de marcar como "Entregado" y generar factura.
                            </p>
                            
                            <form action="{{ route('reparaciones.abonar', $reparacion) }}" method="POST" class="flex flex-col sm:flex-row gap-3">
                                @csrf
                                <div class="flex-1 relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <span class="text-gray-500">L.</span>
                                    </div>
                                    <input type="number" name="monto" step="0.01" min="1" max="{{ $pendiente }}"
                                        class="pl-10 w-full border border-gray-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-amber-200 focus:border-amber-500 shadow-sm transition duration-200"
                                        placeholder="Monto a abonar">
                                </div>
                                <button type="submit"
                                    class="flex items-center gap-2 bg-gradient-to-r from-amber-500 to-yellow-500 hover:from-amber-600 hover:to-yellow-600 text-white px-6 py-3 rounded-xl font-semibold shadow-lg hover:shadow-xl transition-all duration-300">
                                    <i class="fas fa-money-bill-wave"></i>
                                    Registrar Abono
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @elseif($reparacion->estado === 'entregado' && !$reparacion->factura_id)
                <div class="bg-emerald-50/90 border-l-4 border-emerald-500 p-6 rounded-2xl shadow-xl">
                    <div class="flex items-start gap-4">
                        <div class="bg-emerald-100 p-3 rounded-xl text-emerald-600 shadow-inner">
                            <i class="fas fa-file-invoice text-xl"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-gray-800 mb-2">Facturación</h3>
                            <p class="text-gray-700 mb-4">
                                La reparación está lista para ser entregada. Puede generar la factura correspondiente.
                            </p>
                            <form method="POST" action="{{ route('facturar.reparacion', $reparacion->id) }}">
                                @csrf
                                <button type="submit"
                                    class="flex items-center gap-2 bg-gradient-to-r from-emerald-500 to-teal-500 hover:from-emerald-600 hover:to-teal-600 text-white px-6 py-3 rounded-xl font-semibold shadow-lg hover:shadow-xl transition-all duration-300">
                                    <i class="fas fa-file-invoice-dollar"></i>
                                    Generar Factura
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @elseif($reparacion->factura_id)
                <div class="bg-blue-50/90 border-l-4 border-blue-500 p-6 rounded-2xl shadow-xl">
                    <div class="flex items-start gap-4">
                        <div class="bg-blue-100 p-3 rounded-xl text-blue-600 shadow-inner">
                            <i class="fas fa-file-pdf text-xl"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-gray-800 mb-2">Factura Generada</h3>
                            <p class="text-gray-700 mb-4">
                                Esta reparación ya tiene una factura asociada. Puede descargarla en formato PDF.
                            </p>
                            <a href="{{ route('facturas_reparaciones.pdf', $reparacion->factura_id) }}" target="_blank"
                                class="inline-flex items-center gap-2 bg-gradient-to-r from-blue-500 to-indigo-500 hover:from-blue-600 hover:to-indigo-600 text-white px-6 py-3 rounded-xl font-semibold shadow-lg hover:shadow-xl transition-all duration-300">
                                <i class="fas fa-download"></i>
                                Descargar Factura PDF
                            </a>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Historial de seguimiento (Timeline) -->
            <div class="bg-white/90 backdrop-blur-sm p-6 rounded-2xl shadow-xl border border-white/20">
                <h2 class="text-2xl font-bold text-gray-800 mb-6 flex items-center gap-3">
                    <span class="bg-indigo-100 p-2 rounded-xl text-indigo-600 shadow-inner">
                        <i class="fas fa-history"></i>
                    </span>
                    <span class="bg-gradient-to-r from-indigo-600 to-blue-600 bg-clip-text text-transparent">
                        Historial de Seguimiento
                    </span>
                </h2>

                @if($reparacion->seguimientos->count() > 0)
                <div class="relative">
                    <!-- Línea vertical -->
                    <div class="absolute left-6 top-0 bottom-0 w-1 bg-gradient-to-b from-indigo-300 to-indigo-500 rounded-full"></div>
                    
                    <div class="space-y-8 pl-10">
                        @foreach($reparacion->seguimientos as $seg)
                        <div class="relative">
                            <!-- Punto en la línea de tiempo -->
                            <div class="absolute -left-10 top-1 w-6 h-6 bg-indigo-600 rounded-full border-4 border-white shadow-md z-10 flex items-center justify-center">
                                <i class="fas 
                                    {match($seg->estado) {
                                        'recibido' => 'fa-inbox text-white text-xs',
                                        'en_proceso' => 'fa-cogs text-white text-xs',
                                        'listo' => 'fa-check-circle text-white text-xs',
                                        'entregado' => 'fa-box-open text-white text-xs',
                                        default => 'fa-question-circle text-white text-xs',
                                    }}"></i>
                            </div>

                            <!-- Tarjeta de seguimiento -->
                            <div class="bg-gray-50 border border-gray-200 rounded-xl p-6 shadow-sm hover:shadow-md transition-all duration-300">
                                <div class="flex flex-col md:flex-row justify-between gap-4 mb-4">
                                    <div class="flex items-center gap-2">
                                        <i class="fas fa-calendar-alt text-gray-400"></i>
                                        <span class="text-sm font-medium text-gray-600">
                                            {{ $seg->created_at->isoFormat('D MMM YYYY, h:mm a') }}
                                        </span>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <span class="px-3 py-1 rounded-full text-xs font-bold shadow-inner
                                            {{ match($seg->estado) {
                                                'recibido' => 'bg-blue-100 text-blue-800',
                                                'en_proceso' => 'bg-amber-100 text-amber-800',
                                                'listo' => 'bg-emerald-100 text-emerald-800',
                                                'entregado' => 'bg-purple-100 text-purple-800',
                                                default => 'bg-gray-100 text-gray-800',
                                            } }}">
                                            {{ ucfirst(str_replace('_', ' ', $seg->estado)) }}
                                        </span>
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <div class="flex items-center gap-2 mb-2">
                                        <i class="fas fa-user-shield text-gray-400"></i>
                                        <span class="text-sm font-medium text-gray-700">Técnico: {{ $seg->tecnico->name }}</span>
                                    </div>
                                    <div class="bg-white p-4 rounded-lg border border-gray-200">
                                        <p class="text-gray-700 whitespace-pre-line">{{ $seg->descripcion }}</p>
                                    </div>
                                </div>

                                @if ($seg->imagenes && $seg->imagenes->count() > 0)
                                    <div>
                                        <h4 class="font-semibold text-gray-800 mb-2 flex items-center gap-2">
                                            <i class="fas fa-images text-gray-400"></i>
                                            <span>Evidencia fotográfica</span>
                                        </h4>
                                        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3">
                                            @foreach ($seg->imagenes as $img)
                                                <a href="{{ asset('storage/' . $img->ruta_imagen) }}" 
                                                   data-fancybox="gallery-{{ $seg->id }}" 
                                                   data-caption="Seguimiento #{{ $seg->id }} - {{ $seg->created_at->format('d/m/Y') }}"
                                                   class="block group">
                                                    <div class="aspect-w-1 aspect-h-1 overflow-hidden rounded-xl border border-gray-200 shadow-sm group-hover:shadow-md transition duration-300">
                                                        <img src="{{ asset('storage/' . $img->ruta_imagen) }}" 
                                                             alt="Imagen seguimiento"
                                                             class="object-cover w-full h-full group-hover:scale-105 transition duration-300">
                                                    </div>
                                                </a>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @else
                <div class="text-center py-10">
                    <div class="bg-gray-100 p-6 rounded-xl inline-block max-w-md">
                        <div class="bg-white p-4 rounded-full inline-block mb-3 shadow-inner">
                            <i class="fas fa-inbox text-3xl text-gray-400"></i>
                        </div>
                        <h3 class="text-lg font-medium text-gray-700">No hay avances registrados</h3>
                        <p class="text-gray-500 mt-2">Comience registrando el primer avance técnico</p>
                    </div>
                </div>
                @endif
            </div>

            <!-- Historial de abonos -->
            <div class="bg-white/90 backdrop-blur-sm p-6 rounded-2xl shadow-xl border border-white/20">
                <h2 class="text-2xl font-bold text-gray-800 mb-6 flex items-center gap-3">
                    <span class="bg-green-100 p-2 rounded-xl text-green-600 shadow-inner">
                        <i class="fas fa-money-bill-wave"></i>
                    </span>
                    <span class="bg-gradient-to-r from-green-600 to-emerald-600 bg-clip-text text-transparent">
                        Historial de Abonos
                    </span>
                </h2>

                <div class="mb-6">
                    <div class="flex justify-between items-center mb-2">
                        <div class="text-sm text-gray-600">
                            <span class="font-semibold">Costo Total:</span> L. {{ number_format($reparacion->costo_total, 2) }}
                        </div>
                        <div class="text-sm text-gray-600">
                            <span class="font-semibold">Total Abonado:</span> L. {{ number_format($reparacion->abono, 2) }}
                        </div>
                    </div>

                    @php
                        $porcentaje = $reparacion->costo_total > 0 ? ($reparacion->abono / $reparacion->costo_total) * 100 : 0;
                    @endphp

                    <div class="w-full bg-gray-200 rounded-full h-3 mb-2 overflow-hidden shadow-inner">
                        <div class="bg-gradient-to-r from-green-500 to-teal-500 h-3 text-xs text-white text-center leading-3 transition-all duration-500"
                            style="width: {{ $porcentaje }}%">
                        </div>
                    </div>
                    <div class="flex justify-between text-sm text-gray-600">
                        <span>0%</span>
                        <span class="font-medium">{{ number_format($porcentaje, 0) }}%</span>
                        <span>100%</span>
                    </div>
                </div>

                @if ($reparacion->abonos->isEmpty())
                    <div class="text-center py-10">
                        <div class="bg-gray-100 p-6 rounded-xl inline-block max-w-md">
                            <div class="bg-white p-4 rounded-full inline-block mb-3 shadow-inner">
                                <i class="fas fa-money-bill-alt text-3xl text-gray-400"></i>
                            </div>
                            <h3 class="text-lg font-medium text-gray-700">No hay abonos registrados</h3>
                            <p class="text-gray-500 mt-2">Registre el primer abono para comenzar</p>
                        </div>
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Fecha/Hora
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Monto
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Método
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Observaciones
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($reparacion->abonos as $abono)
                                <tr class="hover:bg-gray-50 transition-colors duration-150">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $abono->created_at->format('d/m/Y') }}</div>
                                        <div class="text-xs text-gray-500">{{ $abono->created_at->format('h:i A') }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-green-600">
                                        L. {{ number_format($abono->monto, 2) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $abono->metodo_pago ?? 'Agregado manual' }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-900">
                                        <div class="flex flex-col">
                                            <span>{{ $abono->observaciones ?? 'Desde la vista Seguimiento' }}</span>
                                            @if ($abono->usuario)
                                                <span class="text-xs text-gray-500 mt-1 flex items-center gap-1">
                                                    <i class="fas fa-user-circle"></i>
                                                    {{ $abono->usuario->name }}
                                                </span>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>

            <!-- Botón de volver -->
            <div class="flex justify-end">
                <a href="{{ route('reparaciones.index') }}"
                    class="flex items-center gap-2 bg-gray-200 hover:bg-gray-300 text-gray-800 px-6 py-3 rounded-xl font-medium shadow-sm hover:shadow transition-all duration-300">
                    <i class="fas fa-arrow-left"></i>
                    Volver a la lista
                </a>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        const input = document.getElementById('imagenesInput');
        const previewContainer = document.getElementById('previewContainer');

        input.addEventListener('change', function() {
            previewContainer.innerHTML = '';
            const files = Array.from(this.files);
            if (files.length > 0) {
                previewContainer.classList.remove('hidden');
            } else {
                previewContainer.classList.add('hidden');
            }

            files.forEach(file => {
                if (file.type.startsWith('image/')) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const div = document.createElement('div');
                        div.classList.add('relative', 'group', 'overflow-hidden', 'rounded-xl', 'border', 'border-gray-200', 'shadow-sm', 'hover:shadow-md', 'transition', 'duration-300');
                        div.innerHTML = `
                            <img src="${e.target.result}" class="w-full h-40 object-cover object-center" />
                            <div class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition duration-300 flex items-center justify-center">
                                <span class="text-white text-sm font-medium">Vista previa</span>
                            </div>
                        `;
                        previewContainer.appendChild(div);
                    };
                    reader.readAsDataURL(file);
                }
            });
        });
    </script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.css" />
    <script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.umd.js"></script>
    <script>
        Fancybox.bind("[data-fancybox]", {
            // Opciones de fancybox
        });
    </script>
@endpush

@push('styles')
    <style>
        .animate-fade-in {
            animation: fadeIn 0.6s cubic-bezier(0.22, 1, 0.36, 1) forwards;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Efecto de gradiente animado para botones */
        .btn-gradient {
            background-size: 200% auto;
            transition: all 0.5s ease;
        }

        .btn-gradient:hover {
            background-position: right center;
        }

        /* Efecto de tarjeta flotante */
        .card-hover {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .card-hover:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
        }

        /* Efecto de sombra interna */
        .shadow-inner {
            box-shadow: inset 0 2px 4px 0 rgba(0, 0, 0, 0.05);
        }

        /* Transición para elementos interactivos */
        .transition-all {
            transition-property: all;
            transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
            transition-duration: 150ms;
        }
    </style>
@endpush
@endsection