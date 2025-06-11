@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-2 sm:px-6 lg:px-8 py-8">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-10">
        <div>
            <h1 class="text-3xl sm:text-4xl font-bold text-gray-900 tracking-tight mb-1">👥 Gestión de Usuarios</h1>
            <p class="text-gray-500 text-sm sm:text-base">Administra los usuarios de tu sistema de manera sencilla y eficiente.</p>
        </div>
        <a href="{{ route('usuarios.create') }}"
           class="inline-block bg-gradient-to-r from-indigo-500 to-indigo-700 hover:from-indigo-600 hover:to-indigo-800 transition-colors text-white font-semibold px-4 py-2 sm:px-5 sm:py-2.5 md:px-7 md:py-3 rounded-2xl shadow-lg focus:outline-none focus:ring-2 focus:ring-indigo-400 focus:ring-offset-2 text-sm sm:text-base md:text-lg">
            + Nuevo Usuario
        </a>
    </div>

    <!-- Success Message -->
    @if(session('success'))
        <div class="mb-6 bg-green-50 border border-green-200 text-green-800 px-5 py-3 rounded-xl shadow-md text-sm sm:text-base">
            {{ session('success') }}
        </div>
    @endif

    <!-- Users Table -->
    <div class="overflow-x-auto rounded-2xl shadow-2xl border border-gray-100 bg-white">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gradient-to-r from-gray-50 to-indigo-50">
                <tr>
                    <th class="px-4 sm:px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Nombre</th>
                    <th class="px-4 sm:px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Correo</th>
                    <th class="px-4 sm:px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Rol</th>
                    <th class="px-4 sm:px-6 py-4 text-right text-xs font-bold text-gray-600 uppercase tracking-wider">Acciones</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-100">
                @forelse($usuarios as $usuario)
                <tr class="hover:bg-indigo-50 transition-colors">
                    <td class="px-4 sm:px-6 py-4 whitespace-nowrap text-gray-900 text-sm sm:text-base">{{ $usuario->name }}</td>
                    <td class="px-4 sm:px-6 py-4 whitespace-nowrap text-gray-700 text-sm sm:text-base">{{ $usuario->email }}</td>
                    <td class="px-4 sm:px-6 py-4 whitespace-nowrap">
                        <span class="inline-block bg-indigo-100 text-indigo-700 text-xs px-3 py-1 rounded-full font-medium">
                            {{ $usuario->roles->pluck('name')->join(', ') }}
                        </span>
                    </td>
                    <td class="px-4 sm:px-6 py-4 whitespace-nowrap text-right">
                        <a href="{{ route('usuarios.edit', $usuario->id) }}"
                           class="inline-flex items-center gap-2 bg-white hover:bg-gradient-to-r hover:from-indigo-500 hover:to-indigo-700 hover:text-white text-indigo-700 font-semibold px-3 py-1.5 sm:px-4 sm:py-2 md:px-5 md:py-2.5 rounded-xl shadow border border-indigo-100 transition-all focus:outline-none focus:ring-2 focus:ring-indigo-400 focus:ring-offset-2 text-xs sm:text-sm md:text-base">
                            <span>✏️</span> Editar
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-4 sm:px-6 py-12 text-center text-gray-400 text-base">
                        <div class="flex flex-col items-center gap-2">
                            <svg class="w-10 h-10 sm:w-12 sm:h-12 text-indigo-200 mb-2" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 19.5M12 15.75V19.5M19.5 12a7.5 7.5 0 11-15 0 7.5 7.5 0 0115 0z" />
                            </svg>
                            No hay usuarios registrados aún.
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    @if(method_exists($usuarios, 'links'))
        <div class="mt-8">
            {{ $usuarios->links('vendor.pagination.tailwind') }}
        </div>
    @endif
</div>
@endsection
