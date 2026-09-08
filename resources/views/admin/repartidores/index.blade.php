<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
            <div class="flex items-center gap-3">
                <div class="p-2 bg-blue-100 dark:bg-blue-900 rounded-lg text-blue-600 dark:text-blue-300">
                    <i class="fa-solid fa-motorcycle text-xl"></i>
                </div>
                <h2 class="text-xl font-bold leading-tight text-gray-800 dark:text-gray-200">
                    {{ __('Centro de Control de Delivery & Gestión de Repartidores') }}
                </h2>
            </div>

            <a href="{{ route('admin.repartidores.create') }}" class="bg-gradient-to-r from-blue-600 to-blue-500 hover:from-blue-700 hover:to-blue-600 text-white px-5 py-2.5 rounded-xl font-bold shadow-lg shadow-blue-500/30 transition-all transform hover:-translate-y-0.5 flex items-center gap-2">
                <i class="fa-solid fa-user-plus"></i> Nuevo Repartidor
            </a>
        </div>
    </x-slot>

    <div class="p-6 max-w-7xl mx-auto space-y-8">

        <!-- ========================================== -->
        <!-- SECCIÓN 1: CENTRO DE CONTROL DE DELIVERY   -->
        <!-- ========================================== -->
        
        <!-- Tarjetas Superiores (KPIs) -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div class="bg-white dark:bg-dark-eval-1 border border-gray-100 dark:border-gray-700 rounded-2xl p-4 flex items-center space-x-4 shadow-sm">
                <div class="p-3 bg-amber-500 text-black rounded-xl text-2xl font-bold">📦</div>
                <div>
                    <span class="text-xs text-gray-500 dark:text-gray-400 font-medium">Pedidos hoy</span>
                    <div class="text-2xl font-bold text-gray-800 dark:text-white">27</div>
                    <span class="text-xs text-emerald-500 font-semibold">↑ +12% vs. ayer</span>
                </div>
            </div>

            <div class="bg-white dark:bg-dark-eval-1 border border-gray-100 dark:border-gray-700 rounded-2xl p-4 flex items-center space-x-4 shadow-sm">
                <div class="p-3 bg-emerald-500 text-black rounded-xl text-2xl font-bold">⏱️</div>
                <div>
                    <span class="text-xs text-gray-500 dark:text-gray-400 font-medium">En preparación</span>
                    <div class="text-2xl font-bold text-gray-800 dark:text-white">8</div>
                    <span class="text-xs text-amber-500 font-semibold">• En cocina</span>
                </div>
            </div>

            <div class="bg-white dark:bg-dark-eval-1 border border-gray-100 dark:border-gray-700 rounded-2xl p-4 flex items-center space-x-4 shadow-sm">
                <div class="p-3 bg-blue-600 text-white rounded-xl text-2xl font-bold">🛵</div>
                <div>
                    <span class="text-xs text-gray-500 dark:text-gray-400 font-medium">En camino</span>
                    <div class="text-2xl font-bold text-gray-800 dark:text-white">12</div>
                    <span class="text-xs text-blue-500 font-semibold">• Repartidores activos</span>
                </div>
            </div>

            <div class="bg-white dark:bg-dark-eval-1 border border-gray-100 dark:border-gray-700 rounded-2xl p-4 flex items-center space-x-4 shadow-sm">
                <div class="p-3 bg-red-500 text-white rounded-xl text-2xl font-bold">✓</div>
                <div>
                    <span class="text-xs text-gray-500 dark:text-gray-400 font-medium">Entregados</span>
                    <div class="text-2xl font-bold text-gray-800 dark:text-white">7</div>
                    <span class="text-xs text-gray-400 font-semibold">• Hoy</span>
                </div>
            </div>
        </div>

        <!-- Panel Interactivo: Pedidos en Tiempo Real + Mapa & Resumen -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            
            <!-- Tabla de Pedidos en Tiempo Real -->
            <div class="lg:col-span-2 bg-white dark:bg-dark-eval-1 border border-gray-100 dark:border-gray-700 rounded-2xl p-5 shadow-sm">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-bold text-gray-800 dark:text-white flex items-center gap-2">
                        <i class="fa-solid fa-list-check text-amber-500"></i> Pedidos en tiempo real
                    </h3>
                    <a href="#" class="text-xs text-amber-500 hover:underline font-semibold">Ver todos →</a>
                </div>

                <!-- Filtros Rápidos -->
                <div class="flex gap-2 mb-4 text-xs overflow-x-auto pb-2">
                    <button class="bg-amber-500 text-black px-3.5 py-1.5 rounded-full font-bold shadow-sm">Todos (27)</button>
                    <button class="bg-gray-100 dark:bg-gray-800 text-amber-600 dark:text-amber-400 border border-amber-500/30 px-3.5 py-1.5 rounded-full font-medium whitespace-nowrap">En preparación (8)</button>
                    <button class="bg-gray-100 dark:bg-gray-800 text-blue-600 dark:text-blue-400 border border-blue-500/30 px-3.5 py-1.5 rounded-full font-medium whitespace-nowrap">En camino (12)</button>
                    <button class="bg-gray-100 dark:bg-gray-800 text-emerald-600 dark:text-emerald-400 border border-emerald-500/30 px-3.5 py-1.5 rounded-full font-medium whitespace-nowrap">Entregados (7)</button>
                </div>

                <!-- Tabla de Envíos -->
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs">
                        <thead class="text-gray-400 border-b border-gray-200 dark:border-gray-700">
                            <tr>
                                <th class="pb-3 font-bold uppercase">N° Pedido</th>
                                <th class="pb-3 font-bold uppercase">Cliente</th>
                                <th class="pb-3 font-bold uppercase">Dirección</th>
                                <th class="pb-3 font-bold uppercase">Estado</th>
                                <th class="pb-3 font-bold uppercase">Hora</th>
                                <th class="pb-3 text-right font-bold uppercase">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-700/50">
                            @php
                            $pedidosDemo = [
                                ['id' => '#1028', 'cliente' => 'María López', 'direccion' => 'Av. Los Olivos 123, Lima', 'estado' => 'En preparación', 'color' => 'bg-amber-100 text-amber-700 dark:bg-amber-500/20 dark:text-amber-400 border border-amber-300 dark:border-amber-500/30', 'hora' => '04:28 p.m.'],
                                ['id' => '#1027', 'cliente' => 'Carlos Rojas', 'direccion' => 'Jr. Las Dalias 456, Lima', 'estado' => 'En camino', 'color' => 'bg-blue-100 text-blue-700 dark:bg-blue-500/20 dark:text-blue-400 border border-blue-300 dark:border-blue-500/30', 'hora' => '04:18 p.m.'],
                                ['id' => '#1026', 'cliente' => 'Ana Torres', 'direccion' => 'Calle Los Ángeles 789, Lima', 'estado' => 'Entregado', 'color' => 'bg-emerald-100 text-emerald-700 dark:bg-emerald-500/20 dark:text-emerald-400 border border-emerald-300 dark:border-emerald-500/30', 'hora' => '04:12 p.m.'],
                                ['id' => '#1025', 'cliente' => 'Jorge Silva', 'direccion' => 'Av. Principal 321, Lima', 'estado' => 'En preparación', 'color' => 'bg-amber-100 text-amber-700 dark:bg-amber-500/20 dark:text-amber-400 border border-amber-300 dark:border-amber-500/30', 'hora' => '04:05 p.m.'],
                                ['id' => '#1024', 'cliente' => 'Lucía Fernández', 'direccion' => 'Calle San Martín 654, Lima', 'estado' => 'En camino', 'color' => 'bg-blue-100 text-blue-700 dark:bg-blue-500/20 dark:text-blue-400 border border-blue-300 dark:border-blue-500/30', 'hora' => '03:56 p.m.'],
                                ['id' => '#1023', 'cliente' => 'Diego Castro', 'direccion' => 'Jr. El Sol 987, Lima', 'estado' => 'Entregado', 'color' => 'bg-emerald-100 text-emerald-700 dark:bg-emerald-500/20 dark:text-emerald-400 border border-emerald-300 dark:border-emerald-500/30', 'hora' => '03:48 p.m.'],
                            ];
                            @endphp

                            @foreach($pedidosDemo as $p)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/40 transition-colors">
                                <td class="py-3 font-bold text-gray-900 dark:text-white">{{ $p['id'] }}</td>
                                <td class="py-3 text-gray-700 dark:text-gray-300">👤 {{ $p['cliente'] }}</td>
                                <td class="py-3 text-gray-500 dark:text-gray-400">{{ $p['direccion'] }}</td>
                                <td class="py-3">
                                    <span class="px-2.5 py-1 rounded-full text-[11px] font-bold {{ $p['color'] }}">
                                        ● {{ $p['estado'] }}
                                    </span>
                                </td>
                                <td class="py-3 text-gray-500 dark:text-gray-400">{{ $p['hora'] }}</td>
                                <td class="py-3 text-right">
                                    <button class="bg-amber-500 hover:bg-amber-600 text-black px-3 py-1 rounded-lg font-bold text-xs transition shadow-sm">
                                        Ver
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Lateral: Mapa & Resumen del Día -->
            <div class="space-y-6">
                <!-- Seguimiento en Mapa -->
                <div class="bg-white dark:bg-dark-eval-1 border border-gray-100 dark:border-gray-700 rounded-2xl p-4 shadow-sm">
                    <div class="flex justify-between items-center mb-3">
                        <h4 class="text-sm font-bold text-gray-800 dark:text-white flex items-center gap-1.5">
                            <i class="fa-solid fa-map-location-dot text-amber-500"></i> Seguimiento en tiempo real
                        </h4>
                        <a href="#" class="text-xs text-amber-500 hover:underline font-semibold">Ver mapa →</a>
                    </div>
                    
                    <div class="relative h-48 bg-gray-900 rounded-xl border border-gray-800 overflow-hidden flex items-center justify-center shadow-inner">
                        <div class="absolute text-3xl font-black text-gray-800 tracking-widest select-none">LIMA</div>
                        
                        <!-- Puntos Repartidores -->
                        <div class="absolute top-8 left-12 bg-blue-600 p-2 rounded-full text-xs shadow-lg text-white animate-bounce">🛵</div>
                        <div class="absolute top-20 right-16 bg-emerald-600 p-2 rounded-full text-xs shadow-lg text-white">🛵</div>
                        
                        <!-- Tooltip Pedido Destacado -->
                        <div class="absolute bottom-8 left-1/4 bg-amber-500 p-2 rounded-xl text-black text-xs font-bold shadow-2xl border border-black flex flex-col items-center">
                            <span>Pedido #1027</span>
                            <span class="text-[10px] font-normal">En camino</span>
                        </div>
                    </div>
                </div>

                <!-- Resumen del día -->
                <div class="bg-white dark:bg-dark-eval-1 border border-gray-100 dark:border-gray-700 rounded-2xl p-4 shadow-sm">
                    <h4 class="text-sm font-bold text-gray-800 dark:text-white mb-3 flex items-center gap-1.5">
                        <i class="fa-solid fa-chart-pie text-amber-500"></i> Resumen del día
                    </h4>
                    <div class="grid grid-cols-2 gap-3 text-xs">
                        <div class="bg-gray-50 dark:bg-gray-800/60 p-3 rounded-xl border border-gray-100 dark:border-gray-700">
                            <span class="text-gray-500 dark:text-gray-400">Total pedidos</span>
                            <div class="text-lg font-bold text-gray-900 dark:text-white mt-0.5">27</div>
                            <span class="text-[10px] text-emerald-500 font-bold">+12%</span>
                        </div>
                        <div class="bg-gray-50 dark:bg-gray-800/60 p-3 rounded-xl border border-gray-100 dark:border-gray-700">
                            <span class="text-gray-500 dark:text-gray-400">En preparación</span>
                            <div class="text-lg font-bold text-gray-900 dark:text-white mt-0.5">8</div>
                        </div>
                        <div class="bg-gray-50 dark:bg-gray-800/60 p-3 rounded-xl border border-gray-100 dark:border-gray-700">
                            <span class="text-gray-500 dark:text-gray-400">En camino</span>
                            <div class="text-lg font-bold text-gray-900 dark:text-white mt-0.5">12</div>
                        </div>
                        <div class="bg-gray-50 dark:bg-gray-800/60 p-3 rounded-xl border border-gray-100 dark:border-gray-700">
                            <span class="text-gray-500 dark:text-gray-400">Entregados</span>
                            <div class="text-lg font-bold text-gray-900 dark:text-white mt-0.5">7</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- ========================================== -->
        <!-- SECCIÓN 2: GESTIÓN DE REPARTIDORES         -->
        <!-- ========================================== -->

        <div class="bg-white dark:bg-dark-eval-1 overflow-hidden shadow-xl rounded-2xl border border-gray-100 dark:border-gray-700">
            <div class="p-4 bg-gray-50 dark:bg-gray-800/50 border-b border-gray-100 dark:border-gray-700 flex items-center justify-between">
                <h3 class="text-base font-bold text-gray-800 dark:text-gray-200 flex items-center gap-2">
                    <i class="fa-solid fa-users text-blue-500"></i> Lista de Personal de Reparto
                </h3>
            </div>

            @if($repartidores->isEmpty())
                <div class="flex flex-col items-center justify-center p-12 text-center">
                    <div class="w-16 h-16 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center mb-4">
                        <i class="fa-solid fa-helmet-safety text-3xl text-gray-400"></i>
                    </div>
                    <h3 class="text-lg font-bold text-gray-600 dark:text-gray-300">No hay repartidores registrados</h3>
                    <p class="text-sm text-gray-400 mt-1">Registra a tu equipo de delivery para comenzar.</p>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-800/50">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-black text-gray-400 uppercase tracking-wider">Nombre</th>
                                <th class="px-6 py-4 text-left text-xs font-black text-gray-400 uppercase tracking-wider">Contacto</th>
                                <th class="px-6 py-4 text-left text-xs font-black text-gray-400 uppercase tracking-wider">Vehículo / Placa</th>
                                <th class="px-6 py-4 text-center text-xs font-black text-gray-400 uppercase tracking-wider">Estado</th>
                                <th class="px-6 py-4 text-right text-xs font-black text-gray-400 uppercase tracking-wider">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-700 bg-white dark:bg-dark-eval-1">
                            @foreach($repartidores as $rep)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/30 transition-colors group">

                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-full bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 flex items-center justify-center text-xs font-bold">
                                            {{ substr($rep->nombre, 0, 1) }}
                                        </div>
                                        <div class="text-sm font-bold text-gray-900 dark:text-white">
                                            {{ $rep->nombre }}
                                        </div>
                                    </div>
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($rep->telefono)
                                        <a href="tel:{{ $rep->telefono }}" class="flex items-center gap-2 text-sm text-gray-600 dark:text-gray-300 hover:text-blue-500 transition-colors">
                                            <i class="fa-solid fa-phone text-xs text-gray-400"></i>
                                            {{ $rep->telefono }}
                                        </a>
                                    @else
                                        <span class="text-xs text-gray-400 italic">No registrado</span>
                                    @endif
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center gap-2">
                                        <span class="font-mono text-xs font-bold bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 px-2 py-1 rounded border border-gray-200 dark:border-gray-600 uppercase">
                                            {{ $rep->placa_vehiculo ?? 'S/P' }}
                                        </span>
                                    </div>
                                </td>

                                <td class="px-6 py-4 text-center whitespace-nowrap">
                                    @if($rep->activo)
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400 border border-green-200 dark:border-green-800">
                                            Activo
                                        </span>
                                    @else
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400 border border-red-200 dark:border-red-800">
                                            Inactivo
                                        </span>
                                    @endif
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex items-center justify-end gap-2 opacity-80 group-hover:opacity-100 transition-opacity">

                                        <a href="{{ route('admin.repartidores.edit', $rep->id) }}" class="w-8 h-8 rounded-full bg-indigo-50 text-indigo-600 hover:bg-indigo-100 hover:text-indigo-700 flex items-center justify-center transition-all hover:scale-110 shadow-sm border border-indigo-200" title="Editar Datos">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </a>

                                        <form action="{{ route('admin.repartidores.destroy', $rep->id) }}" method="POST" class="inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" onclick="confirmarEliminacion(event, '{{ $rep->nombre }}')" class="w-8 h-8 rounded-full bg-red-50 text-red-600 hover:bg-red-100 hover:text-red-700 flex items-center justify-center transition-all hover:scale-110 shadow-sm border border-red-200" title="Eliminar Repartidor">
                                                <i class="fa-solid fa-trash-can"></i>
                                            </button>
                                        </form>

                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const mensajeExito = "{{ session('status') }}";
        const mensajeError = "{{ session('error') }}";

        if (mensajeExito) {
            Swal.fire({
                title: '¡Operación Exitosa!',
                text: mensajeExito,
                icon: 'success',
                confirmButtonColor: '#2563EB',
                timer: 2000,
                showConfirmButton: false
            });
        }

        if (mensajeError) {
            Swal.fire({
                title: '¡Ups!',
                text: mensajeError,
                icon: 'error',
                confirmButtonColor: '#EF4444',
                confirmButtonText: 'Entendido'
            });
        }
    });

    function confirmarEliminacion(event, nombre) {
        event.preventDefault();
        const formulario = event.target.closest('form');

        Swal.fire({
            title: '¿Dar de baja a ' + nombre + '?',
            text: "Esta acción lo eliminará de la lista de personal activo.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#EF4444',
            cancelButtonColor: '#9CA3AF',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                formulario.submit();
            }
        });
    }
</script>