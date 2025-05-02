<nav x-data="{ open: false }" class="bg-white/70 backdrop-blur-md dark:bg-gray-800/70 border-b border-gray-200 dark:border-gray-700 shadow-md z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <!-- Logo y Navegación -->
            <div class="flex items-center gap-8">
                <a href="{{ route('dashboard') }}" class="flex items-center">
                    <img src="{{ asset('Logo/logo_menu.png') }}" alt="TavoCell 504" class="h-10 w-auto transition-transform hover:scale-105">
                </a>

                <div class="hidden sm:flex gap-2 items-center">
                    @if (Auth::user()->hasRole('admin'))
                        <div x-data="{ open: false }" class="relative">
                            <button @click="open = !open" class="flex items-center px-3 py-2 text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-white dark:hover:text-blue-400 transition rounded-md">
                                📦 Productos
                                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>
                            <div x-show="open" x-transition:enter="transition ease-out duration-200"
                                x-transition:enter-start="opacity-0 scale-95"
                                x-transition:enter-end="opacity-100 scale-100"
                                x-transition:leave="transition ease-in duration-150"
                                x-transition:leave-start="opacity-100 scale-100"
                                x-transition:leave-end="opacity-0 scale-95"
                                @click.away="open = false"
                                class="absolute left-0 mt-2 w-56 bg-white dark:bg-gray-800 rounded-md shadow-lg ring-1 ring-black ring-opacity-5 z-50">
                                <x-nav-link :href="route('productos.index')" class="block px-4 py-2 text-sm text-gray-700 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700">📋 Ver Productos</x-nav-link>
                                <x-nav-link :href="route('inventario.index')" class="block px-4 py-2 text-sm text-gray-700 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700">📥 Ingreso Inventario</x-nav-link>
                                <x-nav-link :href="route('ajustes-inventario.index')" class="block px-4 py-2 text-sm text-gray-700 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700">🛠️ Ajuste Inventario</x-nav-link>
                            </div>
                        </div>
                    @endif

                    @if (Auth::user()->hasRole('admin'))
                        <x-nav-link :href="route('utilidades.index')" class="px-3 py-2 text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-white dark:hover:text-blue-400 transition">📈 Utilidades</x-nav-link>
                    @endif

                    @if (Auth::user()->hasRole('admin') || Auth::user()->hasRole('cajero'))
                        <x-nav-link :href="route('salidas-caja.index')" class="px-3 py-2 text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-white dark:hover:text-blue-400 transition">💵 Salidas/Caja</x-nav-link>

                        <x-nav-link :href="route('facturas_productos.create')" class="px-3 py-2 text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-white dark:hover:text-blue-400 transition">💸 Facturar</x-nav-link>

                        <x-nav-link :href="route('suscripciones-netflix.index')" class="px-3 py-2 text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-white dark:hover:text-blue-400 transition">🎬 Netflix</x-nav-link>

                        <x-nav-link :href="route('clientes.index')" class="px-3 py-2 text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-white dark:hover:text-blue-400 transition">👤 Clientes</x-nav-link>
                    @endif

                    @if (Auth::user()->hasRole('admin') || Auth::user()->hasRole('cajero') || Auth::user()->hasRole('tecnico'))
                        <x-nav-link :href="route('reparaciones.index')" class="px-3 py-2 text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-white dark:hover:text-blue-400 transition">🛠️ Reparaciones</x-nav-link>
                    @endif

                    @if (Auth::user()->hasRole('admin'))
                        <x-nav-link :href="route('usuarios.index')" class="px-3 py-2 text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-white dark:hover:text-blue-400 transition">🧑‍💼 Usuarios</x-nav-link>
                    @endif
                </div>
            </div>

            <!-- Menú de Usuario -->
            <div class="flex items-center gap-2">
                <div class="relative" x-data="{ openUser: false }">
                    <button @click="openUser = !openUser" class="flex items-center gap-2 text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-white dark:hover:text-blue-400 transition">
                        <div class="bg-blue-600 text-white w-8 h-8 flex items-center justify-center rounded-full font-bold">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        </div>
                        <span class="hidden sm:block">{{ Auth::user()->name }}</span>
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0..." clip-rule="evenodd" />
                        </svg>
                    </button>

                    <div x-show="openUser" x-transition @click.away="openUser = false"
                        class="absolute right-0 mt-2 w-48 bg-white dark:bg-gray-800 rounded-md shadow-md z-50 py-2">
                        <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700">⚙️ Perfil</a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-100 dark:hover:bg-red-900">🚪 Cerrar sesión</button>
                        </form>
                    </div>
                </div>

                <!-- Botón de menú móvil -->
                <button @click="open = ! open" class="sm:hidden p-2 text-gray-600 hover:text-gray-900 dark:text-white dark:hover:text-gray-300 focus:outline-none">
                    <svg x-show="!open" class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                    <svg x-show="open" class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Menú Mobile -->
    <div x-show="open" class="sm:hidden px-4 pb-4 bg-white dark:bg-gray-900 shadow-md">
        <x-responsive-nav-link :href="route('dashboard')">📊 Dashboard</x-responsive-nav-link>
        <x-responsive-nav-link :href="route('productos.index')">📦 Productos</x-responsive-nav-link>
        <x-responsive-nav-link :href="route('inventario.index')">📥 Inventario</x-responsive-nav-link>
        <x-responsive-nav-link :href="route('clientes.index')">👤 Clientes</x-responsive-nav-link>
        <x-responsive-nav-link :href="route('reparaciones.index')">🛠️ Reparaciones</x-responsive-nav-link>
        <x-responsive-nav-link :href="route('facturas_productos.create')">💸 Facturar</x-responsive-nav-link>
        <x-responsive-nav-link :href="route('usuarios.index')">🧑‍💼 Usuarios</x-responsive-nav-link>
        <x-responsive-nav-link :href="route('profile.edit')">⚙️ Perfil</x-responsive-nav-link>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <x-responsive-nav-link href="#" onclick="event.preventDefault(); this.closest('form').submit();">🚪 Cerrar sesión</x-responsive-nav-link>
        </form>
    </div>
</nav>
