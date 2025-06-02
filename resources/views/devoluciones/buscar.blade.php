@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-50 py-8 px-4">
    <div class="w-full max-w-md bg-white rounded-2xl shadow-lg p-8 space-y-8">
        <!-- Título -->
        <div class="flex items-center justify-center space-x-3 mb-6">
            <span class="inline-flex items-center justify-center bg-indigo-100 text-indigo-600 rounded-full p-2">
                <!-- Ícono de búsqueda (Heroicons) -->
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 104.5 4.5a7.5 7.5 0 0012.15 12.15z" />
                </svg>
            </span>
            <h1 class="text-2xl md:text-3xl font-extrabold text-gray-800 tracking-tight">
                Buscar Factura para Devolución
            </h1>
        </div>

        <!-- Mensajes de alerta -->
        @if (session('error'))
            <div class="flex items-center bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-4" role="alert">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" stroke-width="2"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M18.364 5.636l-1.414-1.414A9 9 0 105.636 18.364l1.414 1.414A9 9 0 1018.364 5.636z" />
                </svg>
                <span>{{ session('error') }}</span>
            </div>
        @endif
        @if (session('success'))
            <div class="flex items-center bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-4" role="alert">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" stroke-width="2"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M5 13l4 4L19 7" />
                </svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <!-- Formulario de búsqueda -->
        <form method="POST" action="{{ route('devoluciones.mostrar') }}" class="space-y-6">
            @csrf
            <label for="codigo" class="block text-sm font-medium text-gray-700 mb-1">
                Código de Factura
            </label>
            <div class="relative">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-gray-400">
                    <!-- Ícono de lupa -->
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 104.5 4.5a7.5 7.5 0 0012.15 12.15z" />
                    </svg>
                </span>
                <input
                    type="text"
                    name="codigo"
                    id="codigo"
                    required
                    placeholder="Ej. PROD-00012"
                    class="block w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-gray-800 placeholder-gray-400 transition"
                    autocomplete="off"
                    aria-label="Código de Factura"
                >
            </div>
            <button
                type="submit"
                class="w-full flex justify-center items-center bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-3 rounded-lg shadow-md transition focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 text-lg"
            >
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" stroke-width="2"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 104.5 4.5a7.5 7.5 0 0012.15 12.15z" />
                </svg>
                Buscar Factura
            </button>
        </form>

        <!-- Botón secundario -->
        <div class="text-center pt-2">
            <a href="{{ route('devoluciones.index') }}"
                class="inline-flex items-center justify-center bg-yellow-400 hover:bg-yellow-500 text-yellow-900 font-semibold px-5 py-2.5 rounded-lg shadow transition focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:ring-offset-2">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" stroke-width="2"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M8 6h13M8 12h13M8 18h13M3 6h.01M3 12h.01M3 18h.01" />
                </svg>
                Ver Devoluciones Realizadas
            </a>
        </div>
    </div>
</div>
@endsection
