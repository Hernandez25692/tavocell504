<nav x-data="{ open: false }" class="bg-gradient-to-r from-indigo-700 to-blue-700 shadow-xl">
    <!-- Primary Navigation Menu -->
    <div class="max-w-8xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-20">
            <div class="flex items-center">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}" class="flex items-center group">
                        <img src="{{ asset('Logo/logo_menu.png') }}" alt="TavoCell 504"
                            class="h-12 w-auto transition-all duration-300 group-hover:scale-105 group-hover:rotate-2">
                        <span
                            class="ml-3 text-2xl font-bold text-white tracking-tight hidden md:block">TavoCell504</span>
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden lg:flex lg:items-center lg:space-x-1 ml-8">
                    @if (Auth::user()->hasRole('admin') || Auth::user()->hasRole('cajero'))
                        <!-- Productos -->
                        @if (Auth::user()->hasRole('admin'))
                            <div class="relative group" x-data="{ open: false }" @mouseenter="open = true"
                                @mouseleave="open = false">
                                <button class="nav-dropdown-btn">
                                    <span class="nav-icon">
                                        <i class="fas fa-boxes text-lg"></i>
                                    </span>
                                    <span class="nav-text">Productos</span>
                                    <i class="fas fa-chevron-down text-xs ml-1 transition-transform duration-200"
                                        :class="{ 'rotate-180': open }"></i>
                                </button>
                                <div class="nav-dropdown-menu" x-show="open"
                                    x-transition:enter="transition ease-out duration-200"
                                    x-transition:enter-start="opacity-0 scale-95"
                                    x-transition:enter-end="opacity-100 scale-100"
                                    x-transition:leave="transition ease-in duration-150"
                                    x-transition:leave-start="opacity-100 scale-100"
                                    x-transition:leave-end="opacity-0 scale-95">
                                    <x-nav-link :href="route('productos.index')" class="nav-dropdown-item">
                                        <i class="fas fa-list mr-2"></i> Ver Productos
                                    </x-nav-link>
                                    <x-nav-link :href="route('inventario.index')" class="nav-dropdown-item">
                                        <i class="fas fa-arrow-down mr-2"></i> Ingreso Inventario
                                    </x-nav-link>
                                    <x-nav-link :href="route('ajustes-inventario.index')" class="nav-dropdown-item">
                                        <i class="fas fa-tools mr-2"></i> Ajuste Inventario
                                    </x-nav-link>
                                </div>
                            </div>
                        @endif
                    @endif

                    @if (Auth::user()->hasRole('admin'))
                        <x-nav-link :href="route('utilidades.index')" :active="request()->routeIs('utilidades.index')" class="nav-item">
                            <i class="fas fa-chart-line mr-2"></i>
                            <span class="nav-text">Utilidades</span>
                        </x-nav-link>
                    @endif

                    @if (Auth::user()->hasRole('admin') || Auth::user()->hasRole('cajero'))
                        <x-nav-link :href="route('salidas-caja.index')" :active="request()->routeIs('salidas-caja.*')" class="nav-item">
                            <i class="fas fa-money-bill-wave mr-2"></i>
                            <span class="nav-text">Salidas/Caja</span>
                        </x-nav-link>
                    @endif

                    @if (Auth::user()->hasRole('admin') || Auth::user()->hasRole('cajero'))
                        <!-- Facturación -->
                        <div class="relative group" x-data="{ open: false }" @mouseenter="open = true"
                            @mouseleave="open = false">
                            <button class="nav-dropdown-btn">
                                <span class="nav-icon">
                                    <i class="fas fa-file-invoice-dollar text-lg"></i>
                                </span>
                                <span class="nav-text">Facturación</span>
                                <i class="fas fa-chevron-down text-xs ml-1 transition-transform duration-200"
                                    :class="{ 'rotate-180': open }"></i>
                            </button>
                            <div class="nav-dropdown-menu" x-show="open"
                                x-transition:enter="transition ease-out duration-200"
                                x-transition:enter-start="opacity-0 scale-95"
                                x-transition:enter-end="opacity-100 scale-100"
                                x-transition:leave="transition ease-in duration-150"
                                x-transition:leave-start="opacity-100 scale-100"
                                x-transition:leave-end="opacity-0 scale-95">
                                <x-nav-link :href="route('facturas_productos.create')" class="nav-dropdown-item">
                                    <i class="fas fa-cart-plus mr-2"></i> Nueva Factura Producto
                                </x-nav-link>
                                <x-nav-link :href="route('facturas_productos.index')" class="nav-dropdown-item">
                                    <i class="fas fa-history mr-2"></i> Historial Productos
                                </x-nav-link>
                                <x-nav-link :href="route('facturas_reparaciones.index')" class="nav-dropdown-item">
                                    <i class="fas fa-tools mr-2"></i> Historial Reparaciones
                                </x-nav-link>
                                @if (Auth::user()->hasRole('admin'))
                                    <x-nav-link :href="route('cierres.index')" class="nav-dropdown-item">
                                        <i class="fas fa-lock mr-2"></i> Cierres Diarios
                                    </x-nav-link>
                                @endif
                            </div>
                        </div>
                    @endif

                    @if (Auth::user()->hasRole('admin') || Auth::user()->hasRole('cajero'))
                        <x-nav-link :href="route('suscripciones-netflix.index')" :active="request()->routeIs('suscripciones-netflix.*')" class="nav-item">
                            <i class="fas fa-film mr-2"></i>
                            <span class="nav-text">Suscrip/Netflix</span>
                        </x-nav-link>
                    @endif

                    @if (Auth::user()->hasRole('admin') || Auth::user()->hasRole('cajero'))
                        <!-- Clientes -->
                        <x-nav-link :href="route('clientes.index')" :active="request()->routeIs('clientes.*')" class="nav-item">
                            <i class="fas fa-users mr-2"></i>
                            <span class="nav-text">Clientes</span>
                        </x-nav-link>
                    @endif

                    @if (Auth::user()->hasRole('admin') || Auth::user()->hasRole('cajero') || Auth::user()->hasRole('tecnico'))
                        <!-- Reparaciones -->
                        <x-nav-link :href="route('reparaciones.index')" :active="request()->routeIs('reparaciones.*')" class="nav-item">
                            <i class="fas fa-tools mr-2"></i>
                            <span class="nav-text">Reparaciones</span>
                        </x-nav-link>
                    @endif

                    @if (Auth::user()->hasRole('admin'))
                        <!-- Usuarios -->
                        <x-nav-link :href="route('usuarios.index')" :active="request()->routeIs('usuarios.*')" class="nav-item">
                            <i class="fas fa-user-cog mr-2"></i>
                            <span class="nav-text">Usuarios</span>
                        </x-nav-link>
                    @endif
                </div>
            </div>

            <!-- Menú de Usuario -->
            <div class="hidden lg:flex lg:items-center lg:ms-6" x-data="{ openUser: false }" @click.away="openUser = false">
                <div class="relative">
                    <button @click="openUser = !openUser" class="user-menu-btn flex items-center space-x-2">
                        <div class="user-avatar bg-gradient-to-br from-blue-400 to-indigo-600 shadow-md">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        </div>
                        <span class="user-name text-white font-medium">{{ Auth::user()->name }}</span>
                        <i class="fas fa-chevron-down text-xs text-white transition-transform duration-200"
                            :class="{ 'rotate-180': openUser }"></i>
                    </button>

                    <div x-show="openUser" x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                        x-transition:leave="transition ease-in duration-150"
                        x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                        class="absolute right-0 mt-2 w-56 bg-white rounded-xl shadow-xl z-50 py-2 border border-gray-100">
                        <a href="{{ route('profile.edit') }}"
                            class="user-menu-item block px-4 py-3 text-sm text-gray-700 hover:bg-indigo-50 hover:text-indigo-700 transition-colors duration-200">
                            <i class="fas fa-user-circle mr-2 text-indigo-600"></i>
                            Perfil
                        </a>
                        <div class="border-t border-gray-100 my-1"></div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                class="w-full text-left user-menu-item px-4 py-3 text-sm text-red-600 hover:bg-red-50 transition-colors duration-200">
                                <i class="fas fa-sign-out-alt mr-2"></i>
                                Cerrar sesión
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Hamburger (mobile) -->
            <div class="flex items-center lg:hidden">
                <button @click="open = !open" class="mobile-menu-btn text-white focus:outline-none">
                    <i class="fas fa-bars text-2xl" x-show="!open"></i>
                    <i class="fas fa-times text-2xl" x-show="open"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{ 'block': open, 'hidden': !open }"
        class="lg:hidden bg-gradient-to-b from-indigo-700 to-blue-800 shadow-lg">
        <div class="pt-2 pb-4 space-y-1 px-4">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="mobile-nav-item">
                <i class="fas fa-tachometer-alt mr-3"></i> Dashboard
            </x-responsive-nav-link>

            @role('admin|cajero')
                <div class="mobile-nav-group" x-data="{ open: false }">
                    <button @click="open = !open" class="mobile-nav-header w-full text-left">
                        <i class="fas fa-boxes mr-3"></i> Productos
                        <i class="fas fa-chevron-down text-xs ml-auto transition-transform duration-200"
                            :class="{ 'rotate-180': open }"></i>
                    </button>
                    <div class="mobile-nav-submenu" x-show="open" x-collapse>
                        <x-responsive-nav-link :href="route('productos.index')" class="mobile-nav-subitem">
                            <i class="fas fa-list mr-3"></i> Ver Productos
                        </x-responsive-nav-link>
                        @role('admin')
                            <x-responsive-nav-link :href="route('inventario.index')" class="mobile-nav-subitem">
                                <i class="fas fa-arrow-down mr-3"></i> Ingreso Inventario
                            </x-responsive-nav-link>
                            <x-responsive-nav-link :href="route('ajustes-inventario.index')" class="mobile-nav-subitem">
                                <i class="fas fa-tools mr-3"></i> Ajuste Inventario
                            </x-responsive-nav-link>
                        @endrole
                    </div>
                </div>
            @endrole

            @role('admin')
                <x-responsive-nav-link :href="route('utilidades.index')" :active="request()->routeIs('utilidades.index')" class="mobile-nav-item">
                    <i class="fas fa-chart-line mr-3"></i> Utilidades
                </x-responsive-nav-link>
            @endrole

            @role('admin|cajero')
                <x-responsive-nav-link :href="route('salidas-caja.index')" :active="request()->routeIs('salidas-caja.*')" class="mobile-nav-item">
                    <i class="fas fa-money-bill-wave mr-3"></i> Salidas/Caja
                </x-responsive-nav-link>
            @endrole

            @role('admin|cajero')
                <div class="mobile-nav-group" x-data="{ open: false }">
                    <button @click="open = !open" class="mobile-nav-header w-full text-left">
                        <i class="fas fa-file-invoice-dollar mr-3"></i> Facturación
                        <i class="fas fa-chevron-down text-xs ml-auto transition-transform duration-200"
                            :class="{ 'rotate-180': open }"></i>
                    </button>
                    <div class="mobile-nav-submenu" x-show="open" x-collapse>
                        <x-responsive-nav-link :href="route('facturas_productos.create')" class="mobile-nav-subitem">
                            <i class="fas fa-cart-plus mr-3"></i> Nueva Factura Producto
                        </x-responsive-nav-link>
                        <x-responsive-nav-link :href="route('facturas_productos.index')" class="mobile-nav-subitem">
                            <i class="fas fa-history mr-3"></i> Historial Productos
                        </x-responsive-nav-link>
                        <x-responsive-nav-link :href="route('facturas_reparaciones.index')" class="mobile-nav-subitem">
                            <i class="fas fa-tools mr-3"></i> Historial Reparaciones
                        </x-responsive-nav-link>
                        @role('admin')
                            <x-responsive-nav-link :href="route('cierres.index')" class="mobile-nav-subitem">
                                <i class="fas fa-lock mr-3"></i> Cierres
                            </x-responsive-nav-link>
                        @endrole
                    </div>
                </div>
            @endrole

            @role('admin|cajero')
                <x-responsive-nav-link :href="route('suscripciones-netflix.index')" :active="request()->routeIs('suscripciones-netflix.*')" class="mobile-nav-item">
                    <i class="fas fa-film mr-3"></i> Suscrip/Netflix
                </x-responsive-nav-link>
            @endrole

            @role('admin|cajero')
                <x-responsive-nav-link :href="route('clientes.index')" :active="request()->routeIs('clientes.*')" class="mobile-nav-item">
                    <i class="fas fa-users mr-3"></i> Clientes
                </x-responsive-nav-link>
            @endrole

            @role('admin|cajero|tecnico')
                <x-responsive-nav-link :href="route('reparaciones.index')" :active="request()->routeIs('reparaciones.*')" class="mobile-nav-item">
                    <i class="fas fa-tools mr-3"></i> Reparaciones
                </x-responsive-nav-link>
            @endrole

            @role('admin')
                <x-responsive-nav-link :href="route('usuarios.index')" :active="request()->routeIs('usuarios.*')" class="mobile-nav-item">
                    <i class="fas fa-user-cog mr-3"></i> Usuarios
                </x-responsive-nav-link>
            @endrole
        </div>

        <!-- Responsive user menu -->
        <div class="pt-4 pb-3 border-t border-blue-600 px-4">
            <div class="flex items-center space-x-3 mb-3">
                <div class="user-avatar bg-gradient-to-br from-blue-400 to-indigo-600 shadow-md">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>
                <div>
                    <div class="font-medium text-white">{{ Auth::user()->name }}</div>
                    <div class="text-sm text-blue-200">{{ Auth::user()->email }}</div>
                </div>
            </div>
            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')" class="mobile-user-item">
                    <i class="fas fa-user-circle mr-3"></i> Perfil
                </x-responsive-nav-link>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')" class="mobile-user-item"
                        onclick="event.preventDefault(); this.closest('form').submit();">
                        <i class="fas fa-sign-out-alt mr-3"></i> Cerrar Sesión
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>

<style>
    /* Navigation styles */
    .nav-icon {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 1.5rem;
    }

    .nav-text {
        transition: all 0.3s ease;
    }

    /* Desktop navigation */
    .nav-item {
        display: flex;
        align-items: center;
        padding: 0.75rem 1.25rem;
        font-size: 0.95rem;
        font-weight: 500;
        color: rgba(255, 255, 255, 0.9);
        border-radius: 0.5rem;
        transition: all 0.3s ease;
        margin: 0 0.15rem;
    }

    .nav-item:hover {
        color: white;
        background-color: rgba(255, 255, 255, 0.1);
        transform: translateY(-2px);
    }

    .nav-item.active {
        color: white;
        background-color: rgba(255, 255, 255, 0.2);
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    }

    .nav-dropdown-btn {
        display: flex;
        align-items: center;
        padding: 0.75rem 1.25rem;
        font-size: 0.95rem;
        font-weight: 500;
        color: rgba(255, 255, 255, 0.9);
        border-radius: 0.5rem;
        transition: all 0.3s ease;
        margin: 0 0.15rem;
    }

    .nav-dropdown-btn:hover {
        color: white;
        background-color: rgba(255, 255, 255, 0.1);
        transform: translateY(-2px);
    }

    .nav-dropdown-menu {
        position: absolute;
        z-index: 50;
        min-width: 220px;
        margin-top: 0.5rem;
        background-color: white;
        border: 1px solid #e5e7eb;
        border-radius: 0.75rem;
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        overflow: hidden;
    }

    .nav-dropdown-item {
        display: flex;
        align-items: center;
        padding: 0.75rem 1.25rem;
        font-size: 0.9rem;
        color: #4b5563;
        transition: all 0.2s ease;
    }

    .nav-dropdown-item:hover {
        background-color: #f8fafc;
        color: #1e40af;
        padding-left: 1.5rem;
    }

    /* User menu */
    .user-menu-btn {
        display: flex;
        align-items: center;
        padding: 0.5rem 0.75rem;
        border-radius: 0.75rem;
        transition: all 0.3s ease;
    }

    .user-menu-btn:hover {
        background-color: rgba(255, 255, 255, 0.1);
    }

    .user-avatar {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 2.5rem;
        height: 2.5rem;
        border-radius: 9999px;
        color: white;
        font-weight: 600;
        font-size: 1.1rem;
        transition: all 0.3s ease;
    }

    .user-name {
        font-size: 0.95rem;
        font-weight: 500;
    }

    .user-menu-item {
        display: flex;
        align-items: center;
        padding: 0.75rem 1.25rem;
        font-size: 0.9rem;
        color: #4b5563;
        transition: all 0.2s ease;
    }

    .user-menu-item:hover {
        background-color: #f8fafc;
        color: #1e40af;
    }

    /* Mobile menu */
    .mobile-menu-btn {
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 0.75rem;
        border-radius: 0.5rem;
        color: white;
        transition: all 0.3s ease;
    }

    .mobile-menu-btn:hover {
        background-color: rgba(255, 255, 255, 0.1);
    }

    .mobile-nav-item {
        display: flex;
        align-items: center;
        padding: 0.75rem 1rem;
        border-radius: 0.5rem;
        color: rgba(255, 255, 255, 0.9);
        font-size: 0.95rem;
        transition: all 0.2s ease;
    }

    .mobile-nav-item:hover {
        background-color: rgba(255, 255, 255, 0.1);
        color: white;
    }

    .mobile-nav-item.active {
        background-color: rgba(255, 255, 255, 0.2);
        color: white;
    }

    .mobile-nav-group {
        margin-bottom: 0.25rem;
    }

    .mobile-nav-header {
        display: flex;
        align-items: center;
        padding: 0.75rem 1rem;
        font-size: 0.95rem;
        font-weight: 500;
        color: rgba(255, 255, 255, 0.9);
        border-radius: 0.5rem;
        transition: all 0.2s ease;
    }

    .mobile-nav-header:hover {
        background-color: rgba(255, 255, 255, 0.1);
        color: white;
    }

    .mobile-nav-submenu {
        padding-left: 1.75rem;
        margin-top: 0.25rem;
    }

    .mobile-nav-subitem {
        display: flex;
        align-items: center;
        padding: 0.5rem 1rem;
        font-size: 0.9rem;
        color: rgba(255, 255, 255, 0.8);
        transition: all 0.2s ease;
    }

    .mobile-nav-subitem:hover {
        color: white;
        padding-left: 1.25rem;
    }

    .mobile-user-item {
        display: flex;
        align-items: center;
        padding: 0.75rem 1rem;
        border-radius: 0.5rem;
        color: rgba(255, 255, 255, 0.9);
        font-size: 0.95rem;
        transition: all 0.2s ease;
    }

    .mobile-user-item:hover {
        background-color: rgba(255, 255, 255, 0.1);
        color: white;
    }

    /* Animations */
    .transition-all {
        transition-property: all;
        transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
        transition-duration: 200ms;
    }

    /* Custom scrollbar for dropdowns */
    .nav-dropdown-menu::-webkit-scrollbar {
        width: 6px;
    }

    .nav-dropdown-menu::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }

    .nav-dropdown-menu::-webkit-scrollbar-thumb {
        background: #c1c1c1;
        border-radius: 10px;
    }

    .nav-dropdown-menu::-webkit-scrollbar-thumb:hover {
        background: #a1a1a1;
    }
</style>
