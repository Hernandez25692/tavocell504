@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 px-4 py-8 animate-fade-in">
        <div class="max-w-7xl mx-auto space-y-6">
            <!-- Encabezado con efecto neumorfismo -->
            <div
                class="flex justify-between items-center flex-wrap gap-4 p-6 bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300">
                <h1 class="text-2xl md:text-3xl font-bold text-gray-800 flex items-center gap-3">
                    <span class="bg-indigo-100 p-3 rounded-full text-indigo-600 shadow-inner">
                        🛠️
                    </span>
                    <span class="bg-clip-text text-transparent bg-gradient-to-r from-indigo-600 to-purple-600">
                        Reparaciones Registradas
                    </span>
                </h1>
                <a href="{{ route('reparaciones.create') }}"
                    class="relative overflow-hidden group bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white font-semibold px-6 py-3 rounded-lg shadow-lg transition-all duration-300 transform hover:-translate-y-1">
                    <span class="relative z-10 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                        Nueva Reparación
                    </span>
                    <span
                        class="absolute inset-0 bg-gradient-to-r from-indigo-700 to-purple-700 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></span>
                </a>
            </div>

            <!-- Filtros con diseño de vidrio -->
            <form method="GET" action="{{ route('reparaciones.index') }}"
                class="backdrop-blur-sm bg-white/80 rounded-xl shadow-lg p-6 border border-white/20 transition-all duration-300 hover:shadow-xl">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                    <div class="relative w-full max-w-sm">
                        <input type="text" id="buscar-cliente"
                            class="w-full pl-10 pr-4 py-2 rounded-lg border border-gray-200 focus:ring-2 focus:ring-indigo-200 focus:border-indigo-500 transition-all duration-200 shadow-sm"
                            placeholder="Buscar cliente por nombre..." autocomplete="off">

                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>

                        <!-- Lista de sugerencias -->
                        <ul id="sugerencias-clientes"
                            class="absolute z-10 w-full bg-white border border-gray-300 rounded-md mt-1 max-h-48 overflow-auto hidden shadow-lg">
                        </ul>
                    </div>

                    <div class="relative">
                        <input type="text" name="codigo" value="{{ request('codigo') }}"
                            class="w-full pl-10 pr-4 py-2 rounded-lg border border-gray-200 focus:ring-2 focus:ring-indigo-200 focus:border-indigo-500 transition-all duration-200 shadow-sm"
                            placeholder="Buscar por código (REP-00045)">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                    </div>


                    <select name="estado"
                        class="w-full pl-3 pr-10 py-2 rounded-lg border border-gray-200 focus:ring-2 focus:ring-indigo-200 focus:border-indigo-500 transition-all duration-200 shadow-sm appearance-none bg-white bg-[url('data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIyNCIgaGVpZ2h0PSIyNCIgdmlld0JveD0iMCAwIDI0IDI0IiBmaWxsPSJub25lIiBzdHJva2U9ImN1cnJlbnRDb2xvciIgc3Ryb2tlLXdpZHRoPSIyIiBzdHJva2UtbGluZWNhcD0icm91bmQiIHN0cm9rZS1saW5lam9pbj0icm91bmQiIGNsYXNzPSJsdWNpZGUgbHVjaWRlLWNoZXZyb24tZG93biI+PHBhdGggZD0ibTYgOSA2IDYgNi02Ii8+PC9zdmc+')] bg-no-repeat bg-right-3 bg-center">
                        <option value="">Todos los estados</option>
                        <option value="recibido" {{ request('estado') == 'recibido' ? 'selected' : '' }}>Recibido
                        </option>
                        <option value="en_proceso" {{ request('estado') == 'en_proceso' ? 'selected' : '' }}>En proceso
                        </option>
                        <option value="listo" {{ request('estado') == 'listo' ? 'selected' : '' }}>Listo</option>
                        <option value="entregado" {{ request('estado') == 'entregado' ? 'selected' : '' }}>Entregado
                        </option>
                    </select>
                    <br>
                    <div class="relative">
                        <input type="date" name="desde" value="{{ request('desde') }}"
                            class="w-full pl-10 pr-4 py-2 rounded-lg border border-gray-200 focus:ring-2 focus:ring-indigo-200 focus:border-indigo-500 transition-all duration-200 shadow-sm">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                    </div>

                    <div class="relative">
                        <input type="date" name="hasta" value="{{ request('hasta') }}"
                            class="w-full pl-10 pr-4 py-2 rounded-lg border border-gray-200 focus:ring-2 focus:ring-indigo-200 focus:border-indigo-500 transition-all duration-200 shadow-sm">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end mt-4 gap-3">
                    <button type="submit"
                        class="px-6 py-2.5 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-medium rounded-lg shadow-md transition-all duration-300 transform hover:scale-[1.02] flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                        </svg>
                        Aplicar filtros
                    </button>
                    <a href="{{ route('reparaciones.index') }}"
                        class="px-6 py-2.5 bg-gradient-to-r from-gray-200 to-gray-300 hover:from-gray-300 hover:to-gray-400 text-gray-800 font-medium rounded-lg shadow-md transition-all duration-300 transform hover:scale-[1.02] flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                        Limpiar
                    </a>
                </div>
            </form>

            <!-- Tabla con diseño moderno -->
            <div
                class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-200 transition-all duration-300 hover:shadow-xl">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-300 text-sm advanced-table">
                        <thead>
                            <tr class="bg-gradient-to-r from-indigo-600 to-purple-600 text-white">
                                <th class="px-4 py-3 text-left font-semibold uppercase tracking-wider rounded-tl-2xl sticky top-0 z-10">#</th>
                                <th class="px-4 py-3 text-left font-semibold uppercase tracking-wider sticky top-0 z-10">Código</th>
                                <th class="px-4 py-3 text-left font-semibold uppercase tracking-wider sticky top-0 z-10">Cliente</th>
                                <th class="px-4 py-3 text-left font-semibold uppercase tracking-wider sticky top-0 z-10">Dispositivo</th>
                                <th class="px-4 py-3 text-left font-semibold uppercase tracking-wider sticky top-0 z-10">Falla</th>
                                <th class="px-4 py-3 text-left font-semibold uppercase tracking-wider sticky top-0 z-10">Estado</th>
                                <th class="px-4 py-3 text-left font-semibold uppercase tracking-wider sticky top-0 z-10">Ingreso</th>
                                <th class="px-4 py-3 text-left font-semibold uppercase tracking-wider sticky top-0 z-10">Monto</th>
                                <th class="px-4 py-3 text-center font-semibold uppercase tracking-wider rounded-tr-2xl sticky top-0 z-10">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white">
                            @forelse ($reparaciones->sortByDesc('fecha_ingreso') as $index => $rep)
                                <tr class="hover:bg-indigo-50/70 transition-all duration-200 group border-b-4 border-indigo-200/40">
                                    <td class="px-4 py-3 whitespace-nowrap font-medium text-gray-900">
                                        {{ $reparaciones->firstItem() + $index }}
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap font-semibold text-indigo-700">
                                        REP-{{ str_pad($rep->id, 5, '0', STR_PAD_LEFT) }}
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap font-medium text-gray-800 flex items-center gap-2">
                                        <span class="inline-block w-8 h-8 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center font-bold text-base">
                                            {{ strtoupper(mb_substr($rep->cliente->nombre, 0, 1)) }}
                                        </span>
                                        <span>
                                            {{ $rep->cliente->nombre }}
                                            <br>
                                            <span class="text-xs text-gray-400">{{ $rep->cliente->telefono ?? '' }}</span>
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap text-gray-700">
                                        <span class="font-semibold">{{ $rep->marca }}</span> {{ $rep->modelo }}
                                        <br>
                                        <span class="text-xs text-gray-400">{{ $rep->serie ?? '' }}</span>
                                    </td>
                                    <td class="px-4 py-3 max-w-xs truncate text-gray-600">
                                        {{ \Illuminate\Support\Str::limit($rep->falla_reportada, 30) }}
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        @php
                                            $estadoClases = [
                                                'pendiente' => 'bg-red-100 text-red-700 border border-red-300',
                                                'en_proceso' => 'bg-yellow-100 text-yellow-800 border border-yellow-300',
                                                'listo' => 'bg-green-100 text-green-800 border border-green-300',
                                                'entregado' => 'bg-blue-100 text-blue-800 border border-blue-300',
                                            ];
                                            $estadoClase = $estadoClases[$rep->estado] ?? 'bg-gray-100 text-gray-800 border border-gray-300';
                                        @endphp
                                        <span class="inline-block px-3 py-1 rounded-full text-xs font-bold shadow-sm {{ $estadoClase }}">
                                            {{ ucfirst(str_replace('_', ' ', $rep->estado)) }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap text-gray-600">
                                        {{ \Carbon\Carbon::parse($rep->fecha_ingreso)->format('d/m/Y') }}
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap font-semibold text-gray-900">
                                        L. {{ number_format($rep->costo_total, 2) }}
                                    </td>
                                    <td class="px-2 py-3 whitespace-nowrap text-center flex flex-col gap-2 items-center justify-center min-w-[110px]">
                                        <div class="flex flex-wrap gap-2 justify-center">
                                            {{-- Ver seguimiento --}}
                                            <a href="{{ route('seguimientos.index', $rep->id) }}"
                                                class="inline-flex items-center px-2 py-1 border border-transparent text-xs font-semibold rounded-full shadow text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none transition-all duration-200 hover:scale-105"
                                                title="Ver seguimiento">
                                                <i class="fa-solid fa-eye"></i>
                                            </a>
                                            {{-- Editar reparación --}}
                                            @if ($rep->estado !== 'entregado')
                                                <a href="{{ route('reparaciones.edit', $rep->id) }}"
                                                    class="inline-flex items-center px-2 py-1 text-xs font-semibold rounded-full shadow text-white bg-yellow-500 hover:bg-yellow-600 transition-all duration-200 hover:scale-105"
                                                    title="Editar reparación">
                                                    <i class="fa-solid fa-pen-to-square"></i>
                                                </a>
                                            @endif
                                            {{-- Descargar comprobante --}}
                                            @php
                                                $comprobanteRuta = 'storage/comprobantes/comprobante_reparacion_' . $rep->id . '.pdf';
                                            @endphp
                                            @if (file_exists(public_path($comprobanteRuta)))
                                                <a href="{{ asset($comprobanteRuta) }}"
                                                    class="inline-flex items-center px-2 py-1 text-xs font-semibold rounded-full shadow text-white bg-green-600 hover:bg-green-700 transition-all duration-200 hover:scale-105"
                                                    target="_blank"
                                                    title="Descargar comprobante">
                                                    <i class="fa-solid fa-file-arrow-down"></i>
                                                </a>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="px-6 py-12 text-center">
                                        <div class="flex flex-col items-center justify-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-14 w-14 text-indigo-300 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            <span class="text-lg text-gray-500 font-semibold">No se encontraron reparaciones registradas</span>
                                            <span class="text-sm text-gray-400 mt-1">Intenta ajustar los filtros o agregar una nueva reparación.</span>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" />

                    <style>
                        /* Responsive: Ajustar tabla para evitar scroll horizontal */
                        .advanced-table {
                            table-layout: fixed;
                            width: 100%;
                        }
                        .advanced-table th, .advanced-table td {
                            white-space: normal !important;
                            overflow-wrap: break-word;
                            word-break: break-word;
                            padding-left: 0.5rem;
                            padding-right: 0.5rem;
                        }
                        .advanced-table th, .advanced-table td {
                            font-size: 0.97em;
                        }
                        .advanced-table td {
                            max-width: 160px;
                        }
                        @media (max-width: 1024px) {
                            .advanced-table, .advanced-table thead, .advanced-table tbody, .advanced-table tr, .advanced-table th, .advanced-table td {
                                display: block;
                            }
                            .advanced-table thead tr {
                                display: none;
                            }
                            .advanced-table tr {
                                margin-bottom: 1.5rem;
                                border-radius: 1rem;
                                box-shadow: 0 2px 8px 0 rgba(99,102,241,0.08);
                                border: 2px solid #c7d2fe;
                            }
                            .advanced-table td {
                                padding-left: 45%;
                                position: relative;
                                min-height: 40px;
                                border: none !important;
                                border-bottom: 1px solid #e0e7ff;
                                max-width: 100vw;
                            }
                            .advanced-table td:before {
                                position: absolute;
                                left: 1rem;
                                top: 50%;
                                transform: translateY(-50%);
                                width: 44%;
                                white-space: pre-wrap;
                                font-weight: bold;
                                color: #6366f1;
                                content: attr(data-label);
                            }
                            .advanced-table tr:last-child td {
                                border-bottom: none;
                            }
                        }
                        .advanced-table tr {
                            border-bottom: 4px solid #c7d2fe;
                        }
                        .advanced-table tr:last-child {
                            border-bottom: none;
                        }
                        .advanced-table td, .advanced-table th {
                            transition: background 0.2s, color 0.2s;
                        }
                        .advanced-table td {
                            background: #fff;
                        }
                        .advanced-table tr.bg-indigo-50\/60 td {
                            background: #eef2ff;
                        }
                        /* Responsive buttons */
                        .advanced-table a, .advanced-table button {
                            min-width: 32px;
                            min-height: 32px;
                            font-size: 1em;
                        }
                    </style>
                </div>
            </div>

            <!-- Paginación con diseño mejorado -->
            <div class="flex items-center justify-between pt-4">
                <div class="text-sm text-gray-600">
                    Mostrando <span class="font-medium">{{ $reparaciones->firstItem() }}</span> a
                    <span class="font-medium">{{ $reparaciones->lastItem() }}</span> de
                    <span class="font-medium">{{ $reparaciones->total() }}</span> resultados
                </div>
                <div class="flex space-x-1">
                    {{ $reparaciones->withQueryString()->onEachSide(1)->links() }}

                </div>
            </div>
        </div>
    </div>
    @push('scripts')
        <script>
            const inputBuscar = document.getElementById('buscar-cliente');
            const sugerencias = document.getElementById('sugerencias-clientes');

            // Lista de clientes en minúscula
            const clientes = [
                @foreach ($clientes as $cliente)
                    {
                        id: {{ $cliente->id }},
                        nombre: "{{ strtolower($cliente->nombre) }}"
                    },
                @endforeach
            ];

            inputBuscar.addEventListener('input', function() {
                const texto = this.value.toLowerCase().trim();
                sugerencias.innerHTML = '';

                if (texto.length === 0) {
                    sugerencias.classList.add('hidden');
                    return;
                }

                const coincidencias = clientes.filter(c => c.nombre.includes(texto));

                if (coincidencias.length === 0) {
                    sugerencias.classList.add('hidden');
                    return;
                }

                coincidencias.forEach(c => {
                    const li = document.createElement('li');
                    li.textContent = c.nombre.charAt(0).toUpperCase() + c.nombre.slice(1);
                    li.className = 'px-4 py-2 hover:bg-indigo-100 cursor-pointer';
                    li.addEventListener('click', () => {
                        inputBuscar.value = c.nombre;
                        sugerencias.classList.add('hidden');

                        // Redirigir usando query ?cliente=nombre
                        const url = new URL(window.location.href);
                        url.searchParams.set('cliente', c.nombre);
                        window.location.href = url.toString();
                    });
                    sugerencias.appendChild(li);
                });

                sugerencias.classList.remove('hidden');
            });

            // Ocultar si clic fuera
            document.addEventListener('click', function(e) {
                if (!sugerencias.contains(e.target) && e.target !== inputBuscar) {
                    sugerencias.classList.add('hidden');
                }
            });
        </script>
    @endpush

    @push('styles')
        <style>
            .animate-fade-in {
                animation: fadeIn 0.5s ease-out forwards;
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

            /* Estilo para selects personalizados */
            select {
                -webkit-appearance: none;
                -moz-appearance: none;
                appearance: none;
                background-repeat: no-repeat;
                background-position: right 0.75rem center;
                background-size: 1em;
            }

            /* Efecto hover para filas de tabla */
            tr {
                transition: background-color 0.2s ease, transform 0.2s ease;
            }

            /* Scrollbar personalizado */
            ::-webkit-scrollbar {
                width: 8px;
                height: 8px;
            }

            ::-webkit-scrollbar-track {
                background: #f1f1f1;
                border-radius: 10px;
            }

            ::-webkit-scrollbar-thumb {
                background: #c7d2fe;
                border-radius: 10px;
            }

            ::-webkit-scrollbar-thumb:hover {
                background: #a5b4fc;
            }

            /* Efecto de gradiente animado para botones */
            .btn-gradient {
                background-size: 200% auto;
                transition: 0.5s;
            }

            .btn-gradient:hover {
                background-position: right center;
            }

            /* Efecto de sombra para cards */
            .shadow-lg {
                box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            }

            .shadow-xl {
                box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            }
        </style>
    @endpush

    @if (session('comprobante'))
        <script>
            window.addEventListener('DOMContentLoaded', () => {
                setTimeout(() => {
                    const modal = document.getElementById('comprobanteModal');
                    if (modal) modal.classList.remove('hidden');
                }, 300); // Mostrar tras 300ms
            });

            function cerrarModal() {
                document.getElementById('comprobanteModal').classList.add('hidden');
            }
        </script>

        <div id="comprobanteModal"
            class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40 hidden">
            <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-sm">
                <h2 class="text-xl font-bold text-gray-800 mb-4">✅ Reparación registrada</h2>
                <p class="text-sm text-gray-600 mb-4">¿Deseas descargar el comprobante ahora?</p>
                <div class="flex justify-end gap-3">
                    <a href="{{ asset('storage/comprobantes/' . session('comprobante')) }}" target="_blank"
                        class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 text-sm shadow">
                        Descargar
                    </a>
                    <button onclick="cerrarModal()"
                        class="px-4 py-2 bg-gray-300 text-gray-800 rounded hover:bg-gray-400 text-sm shadow">
                        Cerrar
                    </button>
                </div>
            </div>
        </div>
    @endif
@endsection
