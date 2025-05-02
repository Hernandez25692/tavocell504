<nav x-data="{ open: false }" class="bg-gradient-to-r from-blue-500 via-blue-600 to-blue-700 text-white shadow-lg z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            <!-- Logo -->
            <div class="flex items-center gap-4">
                <a href="{{ route('dashboard') }}" class="flex items-center">
                    <img src="{{ asset('Logo/logo_menu.png') }}" alt="TavoCell 504" class="h-10 w-auto transition-transform hover:scale-110">
                </a>
                <span class="text-lg font-bold hidden sm:block text-white">TavoCell 504</span>
            </div>

            <!-- Desktop Navigation -->
            <div class="hidden sm:flex items-center gap-6">
                @if (Auth::user()->hasRole('admin'))
                    <div x-data="{ open: false }" class="relative">
                        <button @click="open = !open" class="flex items-center gap-1 px-3 py-2 text-sm font-medium text-white hover:bg-blue-600 rounded-md transition">
                            📦 Productos
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <div x-show="open" x-transition @click.away="open = false"
                            class="absolute left-0 mt-2 w-56 bg-white text-gray-800 rounded-md shadow-lg ring-1 ring-black ring-opacity-5 z-50">
                            <x-nav-link :href="route('productos.index')" class="block px-4 py-2 text-sm hover:bg-gray-100">📋 Ver Productos</x-nav-link>
                            <x-nav-link :href="route('inventario.index')" class="block px-4 py-2 text-sm hover:bg-gray-100">📥 Ingreso Inventario</x-nav-link>
                            <x-nav-link :href="route('ajustes-inventario.index')" class="block px-4 py-2 text-sm hover:bg-gray-100">🛠️ Ajuste Inventario</x-nav-link>
                        </div>
                    </div>
                @endif

                @if (Auth::user()->hasRole('admin'))
                    <x-nav-link :href="route('utilidades.index')" class="px-3 py-2 text-sm font-medium text-white hover:bg-blue-600 rounded-md transition">📈 Utilidades</x-nav-link>
                @endif

                @if (Auth::user()->hasRole('admin') || Auth::user()->hasRole('cajero'))
                    <x-nav-link :href="route('salidas-caja.index')" class="px-3 py-2 text-sm font-medium text-white hover:bg-blue-600 rounded-md transition">💵 Salidas/Caja</x-nav-link>
                    <x-nav-link :href="route('facturas_productos.create')" class="px-3 py-2 text-sm font-medium text-white hover:bg-blue-600 rounded-md transition">💸 Facturar</x-nav-link>
                    <x-nav-link :href="route('suscripciones-netflix.index')" class="px-3 py-2 text-sm font-medium text-white hover:bg-blue-600 rounded-md transition">🎬 Netflix</x-nav-link>
                    <x-nav-link :href="route('clientes.index')" class="px-3 py-2 text-sm font-medium text-white hover:bg-blue-600 rounded-md transition">👤 Clientes</x-nav-link>
                @endif

                @if (Auth::user()->hasRole('admin') || Auth::user()->hasRole('cajero') || Auth::user()->hasRole('tecnico'))
                    <x-nav-link :href="route('reparaciones.index')" class="px-3 py-2 text-sm font-medium text-white hover:bg-blue-600 rounded-md transition">🛠️ Reparaciones</x-nav-link>
                @endif

                @if (Auth::user()->hasRole('admin'))
                    <x-nav-link :href="route('usuarios.index')" class="px-3 py-2 text-sm font-medium text-white hover:bg-blue-600 rounded-md transition">🧑‍💼 Usuarios</x-nav-link>
                @endif
            </div>

            <!-- User Menu -->
            <div class="flex items-center gap-4">
                <div class="relative" x-data="{ openUser: false }">
                    <button @click="openUser = !openUser" class="flex items-center gap-2 px-3 py-2 text-sm font-medium text-white hover:bg-blue-600 rounded-md transition">
                        <div class="bg-white text-blue-600 w-8 h-8 flex items-center justify-center rounded-full font-bold">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        </div>
                        <span class="hidden sm:block text-white">{{ Auth::user()->name }}</span>
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0..." clip-rule="evenodd" />
                        </svg>
                    </button>
                    <div x-show="openUser" x-transition @click.away="openUser = false"
                        class="absolute right-0 mt-2 w-48 bg-white text-gray-800 rounded-md shadow-md z-50 py-2">
                        <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm hover:bg-gray-100">⚙️ Perfil</a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-100">🚪 Cerrar sesión</button>
                        </form>
                    </div>
                </div>

                <!-- Mobile Menu Button -->
                <button @click="open = !open" class="sm:hidden p-2 text-white hover:text-gray-300 focus:outline-none">
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

    <!-- Mobile Menu -->
    <div x-show="open" class="sm:hidden px-4 pb-4 bg-blue-600 text-white shadow-md">
        <x-responsive-nav-link :href="route('dashboard')" class="text-white">📊 Dashboard</x-responsive-nav-link>
        <x-responsive-nav-link :href="route('productos.index')" class="text-white">📦 Productos</x-responsive-nav-link>
        <x-responsive-nav-link :href="route('inventario.index')" class="text-white">📥 Inventario</x-responsive-nav-link>
        <x-responsive-nav-link :href="route('clientes.index')" class="text-white">👤 Clientes</x-responsive-nav-link>
        <x-responsive-nav-link :href="route('reparaciones.index')" class="text-white">🛠️ Reparaciones</x-responsive-nav-link>
        <x-responsive-nav-link :href="route('facturas_productos.create')" class="text-white">💸 Facturar</x-responsive-nav-link>
        <x-responsive-nav-link :href="route('usuarios.index')" class="text-white">🧑‍💼 Usuarios</x-responsive-nav-link>
        <x-responsive-nav-link :href="route('profile.edit')" class="text-white">⚙️ Perfil</x-responsive-nav-link>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <x-responsive-nav-link href="#" class="text-white" onclick="event.preventDefault(); this.closest('form').submit();">🚪 Cerrar sesión</x-responsive-nav-link>
        </form>
    </div>
</nav>
