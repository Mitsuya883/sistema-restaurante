<x-perfect-scrollbar
    as="nav"
    aria-label="main"
    class="flex flex-col flex-1 gap-4 px-3">

    @if(Auth::user()->role === 'admin' || Auth::user()->role === 'mozo')
    <div x-transition x-show="isSidebarOpen || isSidebarHovered" class="text-xs font-bold text-gray-400 uppercase tracking-wider mt-2 mb-1">
        Operaciones
    </div>

    <x-sidebar.link title="Control de Salón" href="{{ route('dashboard') }}" :isActive="request()->routeIs('dashboard')">
        <x-slot name="icon">
            <x-icons.dashboard class="flex-shrink-0 w-6 h-6" aria-hidden="true" />
        </x-slot>
    </x-sidebar.link>

    <x-sidebar.link title="Delivery" href="{{ route('orders.delivery') }}" :isActive="request()->routeIs('orders.delivery')">
        <x-slot name="icon">
            <i class="fas fa-phone-alt text-lg w-6 text-center"></i>
        </x-slot>
    </x-sidebar.link>

    <x-sidebar.link title="Despacho Delivery" href="{{ route('orders.dispatch') }}" :isActive="request()->routeIs('orders.dispatch')">
        <x-slot name="icon">
            <i class="fas fa-motorcycle text-lg w-6 text-center"></i>
        </x-slot>
    </x-sidebar.link>

    <x-sidebar.link title="Libro de Reservas" href="{{ route('reservations.index') }}" :isActive="request()->routeIs('reservations.*')">
        <x-slot name="icon">
            <x-heroicon-o-calendar class="flex-shrink-0 w-6 h-6" aria-hidden="true" />
        </x-slot>
    </x-sidebar.link>
    @endif


    @if(Auth::user()->role === 'admin' || Auth::user()->role === 'cocina')
    <div x-transition x-show="isSidebarOpen || isSidebarHovered" class="text-xs font-bold text-gray-400 uppercase tracking-wider mt-4 mb-1">
        Producción
    </div>

    <x-sidebar.link title="Pantalla Cocina" href="{{ route('cocina.index') }}" :isActive="request()->routeIs('cocina.index')">
        <x-slot name="icon">
            <x-heroicon-o-fire class="flex-shrink-0 w-6 h-6" aria-hidden="true" />
        </x-slot>
    </x-sidebar.link>
    @endif


    @if(Auth::user()->role === 'admin')
    <div x-transition x-show="isSidebarOpen || isSidebarHovered" class="text-xs font-bold text-gray-400 uppercase tracking-wider mt-4 mb-1">
        Administración
    </div>

    <x-sidebar.link title="Gestión de Mesas" href="{{ route('admin.mesas.index') }}" :isActive="request()->routeIs('admin.mesas.*')">
        <x-slot name="icon">
            <x-heroicon-o-view-grid class="flex-shrink-0 w-6 h-6" aria-hidden="true" />
        </x-slot>
    </x-sidebar.link>

    <x-sidebar.link title="Gestión de Categorías" href="{{ route('admin.categorias.index') }}" :isActive="request()->routeIs('admin.categorias.*')">
        <x-slot name="icon">
            <x-heroicon-o-tag class="flex-shrink-0 w-6 h-6" aria-hidden="true" />
        </x-slot>
    </x-sidebar.link>

    <x-sidebar.link title="Gestión de Repartidores" href="{{ route('admin.repartidores.index') }}" :isActive="request()->routeIs('admin.repartidores.*')">
        <x-slot name="icon">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
            </svg>
        </x-slot>
    </x-sidebar.link>

    <x-sidebar.link title="Gestión de Platos" href="{{ route('admin.products.index') }}" :isActive="request()->routeIs('admin.products.*')">
        <x-slot name="icon">
            <x-heroicon-o-clipboard-list class="flex-shrink-0 w-6 h-6" aria-hidden="true" />
        </x-slot>
    </x-sidebar.link>

    <x-sidebar.link title="Gestión de Personal" href="{{ route('admin.users.index') }}" :isActive="request()->routeIs('admin.users.*')">
        <x-slot name="icon">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
            </svg>
        </x-slot>
    </x-sidebar.link>

    <x-sidebar.link title="Reporte de Ventas" href="{{ route('admin.reports.index') }}" :isActive="request()->routeIs('admin.reports.index')">
        <x-slot name="icon">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
            </svg>
        </x-slot>
    </x-sidebar.link>

    <!-- <x-sidebar.link title="Configuración" href="#" :isActive="request()->routeIs('settings')">
            <x-slot name="icon">
                <x-heroicon-o-cog class="flex-shrink-0 w-6 h-6" aria-hidden="true" />
            </x-slot>
        </x-sidebar.link> -->
    @endif

</x-perfect-scrollbar>
