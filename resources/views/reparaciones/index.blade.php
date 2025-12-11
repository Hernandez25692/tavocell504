@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-gray-50 via-white to-indigo-50/20 px-4 py-6 animate-fade-in">
        <div class="max-w-7xl mx-auto space-y-6">
            <!-- Encabezado con diseño RMS moderno -->
            <div
                class="flex justify-between items-center flex-wrap gap-4 p-6 bg-white rounded-2xl shadow-xl border border-gray-100 transition-all duration-300 hover:shadow-2xl">
                <div class="flex items-center gap-4">
                    <div class="relative">
                        <div
                            class="w-14 h-14 bg-gradient-to-br from-indigo-600 to-purple-600 rounded-xl flex items-center justify-center shadow-lg">
                            <i class="fas fa-tools text-white text-2xl"></i>
                        </div>
                        <div
                            class="absolute -top-2 -right-2 w-6 h-6 bg-green-500 rounded-full flex items-center justify-center shadow-lg">
                            <span class="text-white text-xs font-bold">{{ $reparaciones->total() }}</span>
                        </div>
                    </div>
                    <div>
                        <h1 class="text-2xl md:text-3xl font-bold text-gray-800">
                            Sistema de Reparaciones
                        </h1>
                        <p class="text-gray-500 text-sm mt-1">
                            <i class="fas fa-chart-line text-indigo-500 mr-1"></i>
                            Gestión profesional de reparaciones
                        </p>
                    </div>
                </div>
                <a href="{{ route('reparaciones.create') }}"
                    class="relative overflow-hidden group bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white font-semibold px-6 py-3 rounded-xl shadow-lg transition-all duration-300 transform hover:-translate-y-1 hover:shadow-xl">
                    <span class="relative z-10 flex items-center gap-2">
                        <i class="fas fa-plus-circle text-lg"></i>
                        Nueva Reparación
                    </span>
                    <span
                        class="absolute inset-0 bg-gradient-to-r from-indigo-700 to-purple-700 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></span>
                </a>
            </div>

            <!-- Filtros con diseño de vidrio y estadísticas -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Panel de filtros -->
                <div class="lg:col-span-2">
                    <form method="GET" action="{{ route('reparaciones.index') }}"
                        class="backdrop-blur-sm bg-white/90 rounded-xl shadow-lg p-6 border border-white/30 transition-all duration-300 hover:shadow-xl">
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 mb-4">
                            <!-- Búsqueda de cliente con autocomplete -->
                            <div class="relative">
                                <div class="relative">
                                    <input type="text" name="cliente" value="{{ request('cliente') }}"
                                        class="w-full pl-10 pr-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-indigo-200 focus:border-indigo-500 transition-all duration-200 shadow-sm bg-white"
                                        placeholder="Buscar cliente...">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-user text-gray-400"></i>
                                    </div>
                                </div>
                            </div>

                            <!-- Código -->
                            <div class="relative">
                                <input type="text" name="codigo" value="{{ request('codigo') }}"
                                    class="w-full pl-10 pr-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-indigo-200 focus:border-indigo-500 transition-all duration-200 shadow-sm bg-white"
                                    placeholder="Código REP-XXX">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-barcode text-gray-400"></i>
                                </div>
                            </div>

                            <!-- Estado -->
                            <div class="relative">
                                <select name="estado"
                                    class="w-full pl-10 pr-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-indigo-200 focus:border-indigo-500 transition-all duration-200 shadow-sm bg-white appearance-none">
                                    <option value="">Todos los estados</option>
                                    <option value="pendiente" {{ request('estado') == 'pendiente' ? 'selected' : '' }}>
                                        Pendiente</option>
                                    <option value="en_proceso" {{ request('estado') == 'en_proceso' ? 'selected' : '' }}>En
                                        proceso</option>
                                    <option value="listo" {{ request('estado') == 'listo' ? 'selected' : '' }}>Listo
                                    </option>
                                    <option value="entregado" {{ request('estado') == 'entregado' ? 'selected' : '' }}>
                                        Entregado</option>
                                </select>
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-tasks text-gray-400"></i>
                                </div>
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <i class="fas fa-chevron-down text-gray-400"></i>
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
                            <!-- Fecha desde -->
                            <div class="relative">
                                <input type="date" name="desde" value="{{ request('desde') }}"
                                    class="w-full pl-10 pr-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-indigo-200 focus:border-indigo-500 transition-all duration-200 shadow-sm bg-white">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-calendar-alt text-gray-400"></i>
                                </div>
                            </div>

                            <!-- Fecha hasta -->
                            <div class="relative">
                                <input type="date" name="hasta" value="{{ request('hasta') }}"
                                    class="w-full pl-10 pr-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-indigo-200 focus:border-indigo-500 transition-all duration-200 shadow-sm bg-white">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-calendar-alt text-gray-400"></i>
                                </div>
                            </div>
                        </div>

                        <div class="flex justify-between items-center pt-4 border-t border-gray-100">
                            <div class="text-sm text-gray-500">
                                <i class="fas fa-filter mr-1"></i>
                                {{ $reparaciones->count() }} reparaciones encontradas
                            </div>
                            <div class="flex gap-3">
                                <button type="submit"
                                    class="px-6 py-2.5 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white font-medium rounded-xl shadow-lg transition-all duration-300 transform hover:scale-[1.02] flex items-center gap-2">
                                    <i class="fas fa-search"></i>
                                    Buscar
                                </button>
                                <a href="{{ route('reparaciones.index') }}"
                                    class="px-6 py-2.5 bg-gradient-to-r from-gray-100 to-gray-200 hover:from-gray-200 hover:to-gray-300 text-gray-700 font-medium rounded-xl shadow-lg transition-all duration-300 transform hover:scale-[1.02] flex items-center gap-2">
                                    <i class="fas fa-times"></i>
                                    Limpiar
                                </a>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Panel de estadísticas -->
                <div class="bg-gradient-to-br from-indigo-600 to-purple-600 rounded-xl shadow-xl p-4 text-white">
                    <h3 class="text-lg font-bold mb-2">Resumen del Sistema</h3>
                    <div class="space-y-2">
                        <div class="flex justify-between items-center p-2 bg-white/10 rounded-lg">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 bg-white/20 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-clock"></i>
                                </div>
                                <div>
                                    <p class="text-sm text-white/80">Pendientes</p>
                                    <p class="text-xl font-bold">{{ $reparaciones->where('estado', 'recibido')->count() }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="flex justify-between items-center p-2 bg-white/10 rounded-lg">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 bg-white/20 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-cogs"></i>
                                </div>
                                <div>
                                    <p class="text-sm text-white/80">En Proceso</p>
                                    <p class="text-xl font-bold">{{ $reparaciones->where('estado', 'en_proceso')->count() }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="flex justify-between items-center p-2 bg-white/10 rounded-lg">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 bg-white/20 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-check-circle"></i>
                                </div>
                                <div>
                                    <p class="text-sm text-white/80">Listas para Entrega</p>
                                    <p class="text-xl font-bold">{{ $reparaciones->where('estado', 'listo')->count() }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="flex justify-between items-center p-2 bg-white/10 rounded-lg">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 bg-white/20 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-box"></i>
                                </div>
                                <div>
                                    <p class="text-sm text-white/80">Entregadas</p>
                                    <p class="text-xl font-bold">{{ $reparaciones->where('estado', 'entregado')->count() }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tabla dinámica con diseño RMS -->
            <div
                class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-200 transition-all duration-300 hover:shadow-xl">
                <!-- Controles de tabla -->
                <div
                    class="p-4 border-b border-gray-200 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                    <div class="flex items-center gap-4">
                        

                        <div class="text-sm text-gray-600 hidden sm:block">
                            <span class="font-semibold text-indigo-600">{{ $reparaciones->total() }}</span> reparaciones
                            en total
                        </div>
                    </div>

                    <div class="flex items-center gap-3">
                        

                        <div class="relative">
                            <input type="text" id="searchTable"
                                class="pl-10 pr-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-indigo-200 focus:border-indigo-500"
                                placeholder="Buscar en tabla...">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-search text-gray-400"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tabla responsive -->
                <div class="overflow-x-auto">
                    <table id="reparacionesTable" class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gradient-to-r from-gray-50 to-gray-100">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider cursor-pointer sortable"
                                    data-column="id">
                                    <div class="flex items-center gap-2">
                                        ID
                                        <i class="fas fa-sort text-gray-400 sort-icon"></i>
                                    </div>
                                </th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider cursor-pointer sortable"
                                    data-column="codigo">
                                    <div class="flex items-center gap-2">
                                        Código
                                        <i class="fas fa-sort text-gray-400 sort-icon"></i>
                                    </div>
                                </th>
                                <th
                                    class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                    Cliente</th>
                                <th
                                    class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                    Dispositivo</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider cursor-pointer sortable"
                                    data-column="estado">
                                    <div class="flex items-center gap-2">
                                        Estado
                                        <i class="fas fa-sort text-gray-400 sort-icon"></i>
                                    </div>
                                </th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider cursor-pointer sortable"
                                    data-column="fecha_ingreso">
                                    <div class="flex items-center gap-2">
                                        Ingreso
                                        <i class="fas fa-sort text-gray-400 sort-icon"></i>
                                    </div>
                                </th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider cursor-pointer sortable"
                                    data-column="costo_total">
                                    <div class="flex items-center gap-2">
                                        Monto
                                        <i class="fas fa-sort text-gray-400 sort-icon"></i>
                                    </div>
                                </th>
                                <th
                                    class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                    Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($reparaciones as $rep)
                                <tr class="hover:bg-indigo-50/50 transition-all duration-200 group"
                                    data-id="{{ $rep->id }}">
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">{{ $rep->id }}</div>
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        <span
                                            class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-indigo-100 text-indigo-800">
                                            REP-{{ str_pad($rep->id, 5, '0', STR_PAD_LEFT) }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10">
                                                <div
                                                    class="h-10 w-10 rounded-full bg-gradient-to-r from-indigo-500 to-purple-500 flex items-center justify-center text-white font-bold">
                                                    {{ strtoupper(mb_substr($rep->cliente->nombre, 0, 1)) }}
                                                </div>
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">{{ $rep->cliente->nombre }}
                                                </div>
                                                <div class="text-sm text-gray-500">
                                                    {{ $rep->cliente->telefono ?? 'Sin teléfono' }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3">
                                        <div class="text-sm font-medium text-gray-900">{{ $rep->marca }}</div>
                                        <div class="text-sm text-gray-500">{{ $rep->modelo }}</div>
                                        @if ($rep->serie)
                                            <div class="text-xs text-gray-400">{{ $rep->serie }}</div>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        @php
                                            $estadoConfig = [
                                                'pendiente' => ['color' => 'red', 'icon' => 'fas fa-clock'],
                                                'en_proceso' => ['color' => 'yellow', 'icon' => 'fas fa-cogs'],
                                                'listo' => ['color' => 'green', 'icon' => 'fas fa-check-circle'],
                                                'entregado' => ['color' => 'blue', 'icon' => 'fas fa-box'],
                                            ];
                                            $config = $estadoConfig[$rep->estado] ?? [
                                                'color' => 'gray',
                                                'icon' => 'fas fa-question',
                                            ];
                                        @endphp
                                        <span
                                            class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full text-sm font-semibold bg-{{ $config['color'] }}-100 text-{{ $config['color'] }}-800 border border-{{ $config['color'] }}-200">
                                            <i class="{{ $config['icon'] }} text-xs"></i>
                                            {{ ucfirst(str_replace('_', ' ', $rep->estado)) }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">
                                            {{ \Carbon\Carbon::parse($rep->created_at)->format('d/m/Y') }}</div>
                                        <div class="text-xs text-gray-500">
                                            {{ \Carbon\Carbon::parse($rep->created_at)->format('H:i') }}</div>
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        <div class="text-sm font-bold text-gray-900">L.
                                            {{ number_format($rep->costo_total, 2) }}</div>
                                        @if ($rep->anticipo > 0)
                                            <div class="text-xs text-green-600">Anticipo: L.
                                                {{ number_format($rep->anticipo, 2) }}</div>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        <div class="flex items-center gap-2">
                                            <a href="{{ route('seguimientos.index', $rep->id) }}"
                                                class="inline-flex items-center px-3 py-1.5 bg-indigo-50 hover:bg-indigo-100 text-indigo-700 rounded-lg transition-all duration-200 group/tooltip relative"
                                                title="Ver seguimiento">
                                                <i class="fas fa-eye mr-1"></i>
                                                <span class="hidden md:inline">Ver</span>
                                                <span
                                                    class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 px-2 py-1 bg-gray-900 text-white text-xs rounded opacity-0 group-hover/tooltip:opacity-100 transition-opacity duration-200 whitespace-nowrap">
                                                    Ver seguimiento
                                                </span>
                                            </a>

                                            @if ($rep->estado !== 'entregado')
                                                <a href="{{ route('reparaciones.edit', $rep->id) }}"
                                                    class="inline-flex items-center px-3 py-1.5 bg-yellow-50 hover:bg-yellow-100 text-yellow-700 rounded-lg transition-all duration-200 group/tooltip relative"
                                                    title="Editar reparación">
                                                    <i class="fas fa-edit mr-1"></i>
                                                    <span class="hidden md:inline">Editar</span>
                                                    <span
                                                        class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 px-2 py-1 bg-gray-900 text-white text-xs rounded opacity-0 group-hover/tooltip:opacity-100 transition-opacity duration-200 whitespace-nowrap">
                                                        Editar reparación
                                                    </span>
                                                </a>
                                            @endif

                                            @php
                                                $comprobanteRuta =
                                                    'storage/comprobantes/comprobante_reparacion_' . $rep->id . '.pdf';
                                            @endphp
                                            @if (file_exists(public_path($comprobanteRuta)))
                                                <a href="{{ asset($comprobanteRuta) }}"
                                                    class="inline-flex items-center px-3 py-1.5 bg-green-50 hover:bg-green-100 text-green-700 rounded-lg transition-all duration-200 group/tooltip relative"
                                                    target="_blank" title="Descargar comprobante">
                                                    <i class="fas fa-file-pdf mr-1"></i>
                                                    <span class="hidden md:inline">PDF</span>
                                                    <span
                                                        class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 px-2 py-1 bg-gray-900 text-white text-xs rounded opacity-0 group-hover/tooltip:opacity-100 transition-opacity duration-200 whitespace-nowrap">
                                                        Descargar comprobante
                                                    </span>
                                                </a>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="px-6 py-12 text-center">
                                        <div class="flex flex-col items-center justify-center">
                                            <div
                                                class="w-20 h-20 bg-indigo-100 rounded-full flex items-center justify-center mb-4">
                                                <i class="fas fa-tools text-indigo-400 text-3xl"></i>
                                            </div>
                                            <h3 class="text-lg font-semibold text-gray-800 mb-2">No hay reparaciones
                                                registradas</h3>
                                            <p class="text-gray-500 mb-4">Comienza agregando una nueva reparación al
                                                sistema.</p>
                                            <a href="{{ route('reparaciones.create') }}"
                                                class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-lg hover:shadow-lg transition-all duration-300">
                                                <i class="fas fa-plus mr-2"></i>
                                                Crear primera reparación
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Paginación personalizada -->
                @if ($reparaciones->hasPages())
                    <div class="px-6 py-4 border-t border-gray-200 bg-gray-50/50">
                        <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
                            <div class="text-sm text-gray-600">
                                Mostrando <span class="font-semibold">{{ $reparaciones->firstItem() }}</span> -
                                <span class="font-semibold">{{ $reparaciones->lastItem() }}</span> de
                                <span class="font-semibold">{{ $reparaciones->total() }}</span> resultados
                            </div>

                            <div class="flex items-center gap-2">
                                <!-- Botón anterior -->
                                @if ($reparaciones->onFirstPage())
                                    <span
                                        class="px-3 py-2 rounded-lg border border-gray-300 text-gray-400 cursor-not-allowed">
                                        <i class="fas fa-chevron-left"></i>
                                    </span>
                                @else
                                    <a href="{{ $reparaciones->previousPageUrl() }}"
                                        class="px-3 py-2 rounded-lg border border-gray-300 hover:bg-gray-50 text-gray-700 transition-colors duration-200">
                                        <i class="fas fa-chevron-left"></i>
                                    </a>
                                @endif

                                <!-- Números de página -->
                                <div class="flex items-center gap-1">
                                    @foreach (range(1, min(5, $reparaciones->lastPage())) as $page)
                                        @if ($page == $reparaciones->currentPage())
                                            <span
                                                class="w-10 h-10 flex items-center justify-center rounded-lg bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-semibold shadow">
                                                {{ $page }}
                                            </span>
                                        @else
                                            <a href="{{ $reparaciones->url($page) }}"
                                                class="w-10 h-10 flex items-center justify-center rounded-lg border border-gray-300 hover:bg-gray-50 text-gray-700 transition-colors duration-200">
                                                {{ $page }}
                                            </a>
                                        @endif
                                    @endforeach

                                    @if ($reparaciones->lastPage() > 5)
                                        <span class="px-2 text-gray-500">...</span>
                                        <a href="{{ $reparaciones->url($reparaciones->lastPage()) }}"
                                            class="w-10 h-10 flex items-center justify-center rounded-lg border border-gray-300 hover:bg-gray-50 text-gray-700 transition-colors duration-200">
                                            {{ $reparaciones->lastPage() }}
                                        </a>
                                    @endif
                                </div>

                                <!-- Botón siguiente -->
                                @if ($reparaciones->hasMorePages())
                                    <a href="{{ $reparaciones->nextPageUrl() }}"
                                        class="px-3 py-2 rounded-lg border border-gray-300 hover:bg-gray-50 text-gray-700 transition-colors duration-200">
                                        <i class="fas fa-chevron-right"></i>
                                    </a>
                                @else
                                    <span
                                        class="px-3 py-2 rounded-lg border border-gray-300 text-gray-400 cursor-not-allowed">
                                        <i class="fas fa-chevron-right"></i>
                                    </span>
                                @endif
                            </div>

                            <div class="text-sm text-gray-500">
                                Página <span class="font-semibold">{{ $reparaciones->currentPage() }}</span> de
                                <span class="font-semibold">{{ $reparaciones->lastPage() }}</span>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    @push('styles')
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" />
        <style>
            .animate-fade-in {
                animation: fadeIn 0.6s ease-out forwards;
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

            /* Scrollbar personalizado */
            ::-webkit-scrollbar {
                width: 10px;
                height: 10px;
            }

            ::-webkit-scrollbar-track {
                background: #f1f1f1;
                border-radius: 10px;
            }

            ::-webkit-scrollbar-thumb {
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                border-radius: 10px;
            }

            ::-webkit-scrollbar-thumb:hover {
                background: linear-gradient(135deg, #5a67d8 0%, #6b46c1 100%);
            }

            /* Efectos hover para elementos interactivos */
            .hover-lift {
                transition: transform 0.3s ease, box-shadow 0.3s ease;
            }

            .hover-lift:hover {
                transform: translateY(-2px);
                box-shadow: 0 10px 25px -5px rgba(102, 126, 234, 0.1), 0 10px 10px -5px rgba(102, 126, 234, 0.04);
            }

            /* Responsive table */
            @media (max-width: 768px) {
                #reparacionesTable thead {
                    display: none;
                }

                #reparacionesTable tr {
                    display: block;
                    margin-bottom: 1rem;
                    border: 1px solid #e5e7eb;
                    border-radius: 0.75rem;
                    padding: 1rem;
                    background: white;
                    box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1);
                }

                #reparacionesTable td {
                    display: flex;
                    justify-content: space-between;
                    align-items: center;
                    padding: 0.75rem 0;
                    border-bottom: 1px solid #f3f4f6;
                }

                #reparacionesTable td:last-child {
                    border-bottom: none;
                }

                #reparacionesTable td::before {
                    content: attr(data-label);
                    font-weight: 600;
                    color: #4f46e5;
                    min-width: 120px;
                }

                #reparacionesTable td .flex {
                    flex-direction: row !important;
                    justify-content: flex-end;
                }
            }

            /* Animación para tooltips */
            @keyframes fadeInUp {
                from {
                    opacity: 0;
                    transform: translate(-50%, 10px);
                }

                to {
                    opacity: 1;
                    transform: translate(-50%, 0);
                }
            }

            /* Estilos para paginación */
            .pagination-item {
                transition: all 0.2s ease;
            }

            .pagination-item:hover:not(.active) {
                background-color: #f3f4f6;
                border-color: #d1d5db;
            }
        </style>
    @endpush

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Ordenamiento de columnas
                document.querySelectorAll('.sortable').forEach(header => {
                    header.addEventListener('click', function() {
                        const column = this.dataset.column;
                        const currentUrl = new URL(window.location.href);
                        const currentSort = currentUrl.searchParams.get('sort');
                        const currentDirection = currentUrl.searchParams.get('direction');

                        let newDirection = 'asc';
                        if (currentSort === column && currentDirection === 'asc') {
                            newDirection = 'desc';
                        }

                        currentUrl.searchParams.set('sort', column);
                        currentUrl.searchParams.set('direction', newDirection);

                        window.location.href = currentUrl.toString();
                    });
                });

                // Búsqueda en tabla
                const searchTable = document.getElementById('searchTable');
                if (searchTable) {
                    searchTable.addEventListener('input', function() {
                        const searchTerm = this.value.toLowerCase();
                        const rows = document.querySelectorAll('#reparacionesTable tbody tr');

                        rows.forEach(row => {
                            const text = row.textContent.toLowerCase();
                            row.style.display = text.includes(searchTerm) ? '' : 'none';
                        });
                    });
                }

                // Cambiar filas por página
                const filasPorPagina = document.getElementById('filasPorPagina');
                if (filasPorPagina) {
                    filasPorPagina.addEventListener('change', function() {
                        const currentUrl = new URL(window.location.href);
                        currentUrl.searchParams.set('perPage', this.value);
                        window.location.href = currentUrl.toString();
                    });
                }

                // Exportar datos
                const exportBtn = document.getElementById('exportBtn');
                if (exportBtn) {
                    exportBtn.addEventListener('click', function() {
                        // Aquí iría la lógica para exportar
                        alert('Función de exportación habilitada. Los datos se prepararán para descarga.');
                        // En una implementación real, esto podría generar un CSV o PDF
                    });
                }

                // Agregar labels para responsive
                if (window.innerWidth <= 768) {
                    const headers = document.querySelectorAll('#reparacionesTable thead th');
                    const rows = document.querySelectorAll('#reparacionesTable tbody tr');

                    rows.forEach(row => {
                        const cells = row.querySelectorAll('td');
                        cells.forEach((cell, index) => {
                            if (headers[index]) {
                                cell.setAttribute('data-label', headers[index].textContent.trim());
                            }
                        });
                    });
                }
            });

            // Manejo del modal de comprobante
            @if (session('comprobante'))
                window.addEventListener('DOMContentLoaded', () => {
                    setTimeout(() => {
                        const modal = document.getElementById('comprobanteModal');
                        if (modal) {
                            modal.classList.remove('hidden');
                            modal.classList.add('flex');
                        }
                    }, 500);
                });

                function cerrarModal() {
                    const modal = document.getElementById('comprobanteModal');
                    if (modal) {
                        modal.classList.add('hidden');
                        modal.classList.remove('flex');
                    }
                }
            @endif
        </script>
    @endpush

    @if (session('comprobante'))
        <div id="comprobanteModal"
            class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm hidden">
            <div class="bg-white rounded-xl shadow-2xl p-6 w-full max-w-md mx-4">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-check text-green-600"></i>
                        </div>
                        <div>
                            <h2 class="text-xl font-bold text-gray-800">¡Reparación registrada!</h2>
                            <p class="text-sm text-gray-600">La reparación se ha guardado exitosamente</p>
                        </div>
                    </div>
                    <button onclick="cerrarModal()" class="text-gray-400 hover:text-gray-600">
                        <i class="fas fa-times text-lg"></i>
                    </button>
                </div>

                <p class="text-gray-700 mb-6">
                    Se ha generado el comprobante de la reparación. ¿Deseas descargarlo ahora?
                </p>

                <div class="flex justify-end gap-3">
                    <a href="{{ asset('storage/comprobantes/' . session('comprobante')) }}" target="_blank"
                        class="px-5 py-2.5 bg-gradient-to-r from-green-500 to-emerald-600 text-white rounded-lg hover:shadow-lg transition-all duration-300 flex items-center gap-2">
                        <i class="fas fa-download"></i>
                        Descargar Comprobante
                    </a>
                    <button onclick="cerrarModal()"
                        class="px-5 py-2.5 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-all duration-300">
                        Cerrar
                    </button>
                </div>
            </div>
        </div>
    @endif
@endsection
