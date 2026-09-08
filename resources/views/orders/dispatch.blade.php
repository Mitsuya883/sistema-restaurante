<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
            <div class="flex items-center gap-3">
                <div class="p-2 bg-amber-500/10 rounded-lg text-amber-500">
                    <i class="fa-solid fa-truck-fast text-xl"></i>
                </div>
                <h2 class="text-xl font-bold leading-tight text-gray-800 dark:text-gray-200">
                    {{ __('Centro de Control de Delivery') }}
                </h2>
            </div>
            <div class="text-xs font-semibold text-gray-500 dark:text-gray-400 bg-gray-100 dark:bg-gray-800 px-3 py-1.5 rounded-lg border border-gray-200 dark:border-gray-700">
                <i class="fa-regular fa-calendar-days mr-1 text-amber-500"></i> {{ now()->format('d/m/Y h:i A') }}
            </div>
        </div>
    </x-slot>

    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

    <div class="p-6 max-w-7xl mx-auto space-y-6">
        
        <!-- Tarjetas Superiores (KPIs) -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div class="bg-white dark:bg-dark-eval-1 border border-gray-100 dark:border-gray-700 rounded-2xl p-4 flex items-center space-x-4 shadow-sm">
                <div class="p-3 bg-amber-500 text-black rounded-xl text-2xl font-bold">📦</div>
                <div>
                    <span class="text-xs text-gray-500 dark:text-gray-400 font-medium">Pedidos hoy</span>
                    <div class="text-2xl font-bold text-gray-800 dark:text-white">{{ $totalHoy }}</div>
                    <span class="text-xs text-emerald-500 font-semibold">• Registrados</span>
                </div>
            </div>

            <div class="bg-white dark:bg-dark-eval-1 border border-gray-100 dark:border-gray-700 rounded-2xl p-4 flex items-center space-x-4 shadow-sm">
                <div class="p-3 bg-emerald-500 text-black rounded-xl text-2xl font-bold">⏱️</div>
                <div>
                    <span class="text-xs text-gray-500 dark:text-gray-400 font-medium">En preparación</span>
                    <div class="text-2xl font-bold text-gray-800 dark:text-white">{{ $enPreparacion }}</div>
                    <span class="text-xs text-amber-500 font-semibold">• En cocina</span>
                </div>
            </div>

            <div class="bg-white dark:bg-dark-eval-1 border border-gray-100 dark:border-gray-700 rounded-2xl p-4 flex items-center space-x-4 shadow-sm">
                <div class="p-3 bg-blue-600 text-white rounded-xl text-2xl font-bold">🛵</div>
                <div>
                    <span class="text-xs text-gray-500 dark:text-gray-400 font-medium">En camino</span>
                    <div class="text-2xl font-bold text-gray-800 dark:text-white">{{ $enCamino }}</div>
                    <span class="text-xs text-blue-500 font-semibold">• Repartidores en ruta</span>
                </div>
            </div>

            <div class="bg-white dark:bg-dark-eval-1 border border-gray-100 dark:border-gray-700 rounded-2xl p-4 flex items-center space-x-4 shadow-sm">
                <div class="p-3 bg-indigo-600 text-white rounded-xl text-2xl font-bold">✓</div>
                <div>
                    <span class="text-xs text-gray-500 dark:text-gray-400 font-medium">Entregados hoy</span>
                    <div class="text-2xl font-bold text-gray-800 dark:text-white">{{ $entregadosHoy }}</div>
                    <span class="text-xs text-indigo-500 font-semibold">• Finalizados</span>
                </div>
            </div>
        </div>

        <!-- Panel Interactivo -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            
            <!-- Tabla de Pedidos -->
            <div class="lg:col-span-2 bg-white dark:bg-dark-eval-1 border border-gray-100 dark:border-gray-700 rounded-2xl p-5 shadow-sm">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-bold text-gray-800 dark:text-white flex items-center gap-2">
                        <i class="fa-solid fa-list-check text-amber-500"></i> Pedidos en tiempo real
                    </h3>
                </div>

                @if($pedidosPendientes->isEmpty())
                    <div class="flex flex-col items-center justify-center p-12 text-center">
                        <div class="w-16 h-16 bg-gray-100 dark:bg-gray-800 rounded-full flex items-center justify-center mb-4">
                            <i class="fa-solid fa-motorcycle text-3xl text-gray-400"></i>
                        </div>
                        <h4 class="text-base font-bold text-gray-600 dark:text-gray-300">No hay pedidos pendientes</h4>
                        <p class="text-xs text-gray-400 mt-1">Los nuevos pedidos de delivery aparecerán aquí.</p>
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-xs">
                            <thead class="text-gray-400 border-b border-gray-200 dark:border-gray-700">
                                <tr>
                                    <th class="pb-3 font-bold uppercase">N° Pedido</th>
                                    <th class="pb-3 font-bold uppercase">Cliente / Dirección</th>
                                    <th class="pb-3 font-bold uppercase">Repartidor</th>
                                    <th class="pb-3 font-bold uppercase">Estado</th>
                                    <th class="pb-3 font-bold uppercase text-right">Acción</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 dark:divide-gray-700/50">
                                @foreach($pedidosPendientes as $pedido)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/40 transition-colors">
                                    <td class="py-3 font-bold text-gray-900 dark:text-white">#{{ $pedido->id }}</td>
                                    <td class="py-3 text-gray-700 dark:text-gray-300">
                                        <div class="font-bold">👤 {{ $pedido->customer->name ?? 'Cliente General' }}</div>
                                        <div class="text-[11px] text-gray-400">{{ $pedido->customer->address ?? 'Sin dirección' }}</div>
                                    </td>
                                    <td class="py-3 text-gray-500 dark:text-gray-400">
                                        @if($pedido->repartidor)
                                            <span class="font-bold text-blue-600 dark:text-blue-400">🛵 {{ $pedido->repartidor->nombre }}</span>
                                        @else
                                            <form action="{{ route('orders.assignDriver', $pedido->id) }}" method="POST" class="flex items-center gap-1">
                                                @csrf
                                                <select name="repartidor_id" required class="text-[11px] py-1 px-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-800 dark:text-gray-200 focus:ring-amber-500">
                                                    <option value="">Asignar...</option>
                                                    @foreach($repartidores as $rep)
                                                        <option value="{{ $rep->id }}">{{ $rep->nombre }}</option>
                                                    @endforeach
                                                </select>
                                                <button type="submit" class="bg-amber-500 hover:bg-amber-600 text-black px-2 py-1 rounded-lg font-bold text-[10px] transition">
                                                    Ok
                                                </button>
                                            </form>
                                        @endif
                                    </td>
                                    <td class="py-3">
                                        @if($pedido->status == 'en_camino')
                                            <span class="px-2.5 py-1 rounded-full text-[11px] font-bold bg-blue-100 text-blue-700 dark:bg-blue-500/20 dark:text-blue-400 border border-blue-300 dark:border-blue-500/30">
                                                ● En Camino
                                            </span>
                                        @else
                                            <span class="px-2.5 py-1 rounded-full text-[11px] font-bold bg-amber-100 text-amber-700 dark:bg-amber-500/20 dark:text-amber-400 border border-amber-300 dark:border-amber-500/30">
                                                ● {{ ucfirst($pedido->status) }}
                                            </span>
                                        @endif
                                    </td>
                                    <td class="py-3 text-right">
                                        <span class="text-[11px] text-gray-400 font-mono">
                                            {{ $pedido->created_at ? $pedido->created_at->format('h:i a') : '--:--' }}
                                        </span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>

            <!-- Panel Lateral: Mapa de Trujillo & Resultado del Día -->
            <div class="space-y-6">
                <!-- Mapa de Trujillo -->
                <div class="bg-white dark:bg-dark-eval-1 border border-gray-100 dark:border-gray-700 rounded-2xl p-4 shadow-sm">
                    <div class="flex justify-between items-center mb-3">
                        <h4 class="text-sm font-bold text-gray-800 dark:text-white flex items-center gap-1.5">
                            <i class="fa-solid fa-map-location-dot text-amber-500"></i> Cobertura Trujillo
                        </h4>
                        <span class="text-[10px] font-bold bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400 px-2 py-0.5 rounded-full border border-emerald-300 dark:border-emerald-700">GPS Activo</span>
                    </div>
                    
                    <div id="mapa-trujillo" class="h-48 rounded-xl border border-gray-200 dark:border-gray-700 z-10 overflow-hidden shadow-inner"></div>
                </div>

                <!-- Resultado del Día -->
                <div class="bg-white dark:bg-dark-eval-1 border border-gray-100 dark:border-gray-700 rounded-2xl p-4 shadow-sm">
                    <h4 class="text-sm font-bold text-gray-800 dark:text-white mb-3 flex items-center gap-1.5">
                        <i class="fa-solid fa-chart-pie text-amber-500"></i> Resultado del día
                    </h4>
                    
                    <div class="grid grid-cols-2 gap-3 text-xs">
                        <div class="bg-gray-50 dark:bg-gray-800/60 p-3 rounded-xl border border-gray-100 dark:border-gray-700">
                            <span class="text-gray-500 dark:text-gray-400">Total Pedidos</span>
                            <div class="text-lg font-bold text-gray-900 dark:text-white mt-0.5">
                                {{ $totalHoy }}
                            </div>
                        </div>

                        <div class="bg-gray-50 dark:bg-gray-800/60 p-3 rounded-xl border border-gray-100 dark:border-gray-700">
                            <span class="text-gray-500 dark:text-gray-400">En preparación</span>
                            <div class="text-lg font-bold text-amber-600 dark:text-amber-400 mt-0.5">
                                {{ $enPreparacion }}
                            </div>
                        </div>

                        <div class="bg-gray-50 dark:bg-gray-800/60 p-3 rounded-xl border border-gray-100 dark:border-gray-700">
                            <span class="text-gray-500 dark:text-gray-400">En camino</span>
                            <div class="text-lg font-bold text-blue-600 dark:text-blue-400 mt-0.5">
                                {{ $enCamino }}
                            </div>
                        </div>

                        <div class="bg-gray-50 dark:bg-gray-800/60 p-3 rounded-xl border border-gray-100 dark:border-gray-700">
                            <span class="text-gray-500 dark:text-gray-400">Repartidores</span>
                            <div class="text-lg font-bold text-indigo-600 dark:text-indigo-400 mt-0.5">
                                {{ $repartidores->count() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Coordenadas de Trujillo, Perú
            const latTrujillo = -8.1116;
            const lngTrujillo = -79.0286;
            const map = L.map('mapa-trujillo').setView([latTrujillo, lngTrujillo], 13);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; OpenStreetMap'
            }).addTo(map);

            L.marker([latTrujillo, lngTrujillo])
                .addTo(map)
                .bindPopup('<b>Torremolinos Restaurant</b><br>Centro Operativo Delivery')
                .openPopup();
        });
    </script>
</x-app-layout>