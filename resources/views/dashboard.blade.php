<x-app-layout>
    <style>
        :root {
            --orange: #f7931e;
            --orange-dark: #e8720c;

            --dark-bg: #121318;

            --panel-bg: rgba(19, 26, 43, 0.85);
            --card-bg: rgba(26, 36, 56, 0.7);
            --border-faint: rgba(255, 255, 255, 0.08);
            --text-light: #f4f4f4;
            --text-muted: #9aa4b8;
        }

        body {
            background-color: var(--dark-bg);
            color: var(--text-light);
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
        }

        .main-container {
            background: var(--dark-bg);
            min-height: calc(100vh - 65px);
        }

        .panel-card {
            background: var(--panel-bg);
            border: 1px solid var(--border-faint);
            border-radius: 16px;
        }

        .table-card {
            background: var(--card-bg);
            border-radius: 14px;
            transition: all 0.25s ease;
            position: relative;
            cursor: pointer;
            text-decoration: none;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .table-card.status-free {
            border: 1.5px solid #22c55e;
            box-shadow: 0 0 15px rgba(34, 197, 94, 0.1);
        }

        .table-card.status-occupied {
            border: 1.5px solid #ef4444;
            box-shadow: 0 0 15px rgba(239, 68, 68, 0.1);
        }

        .table-card.status-reserved {
            border: 1.5px solid var(--orange);
            box-shadow: 0 0 15px rgba(247, 147, 30, 0.1);
        }

        .table-card:hover {
            transform: translateY(-4px) scale(1.02);
            filter: brightness(1.1);
        }

        .table-2d {
            filter: drop-shadow(0 4px 8px rgba(0,0,0,0.4));
        }

        .badge-pill {
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.72rem;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .badge-free-bg { background: rgba(34, 197, 94, 0.15); color: #4ade80; }
        .badge-occupied-bg { background: rgba(239, 68, 68, 0.15); color: #f87171; }
        .badge-reserved-bg { background: rgba(247, 147, 30, 0.15); color: #fbbf24; }

        .btn-blue {
            background: #2563eb;
            color: #fff;
            transition: filter 0.2s;
        }
        .btn-blue:hover { filter: brightness(1.1); }

        .btn-orange {
            background: linear-gradient(90deg, var(--orange), var(--orange-dark));
            color: #fff;
            transition: filter 0.2s;
        }
        .btn-orange:hover { filter: brightness(1.1); }
    </style>

    @php
        $listaMesas = $mesas ?? collect([]);
        $cntLibres = isset($mesas) ? $mesas->whereIn('estado', ['libre', 'disponible'])->count() : 3;
        $cntOcupadas = isset($mesas) ? $mesas->where('estado', 'ocupada')->count() : 1;
        $cntReservadas = isset($mesas) ? $mesas->where('estado', 'reservada')->count() : 1;
        $cntTotal = isset($mesas) ? $mesas->count() : 5;
    @endphp

    <div class="main-container p-6" x-data="{ vista: 'mapa' }">
        <!-- HEADER TOP BAR -->
        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4 mb-6">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-orange-500 flex items-center justify-center text-white shadow-lg shadow-orange-500/30">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-white tracking-tight">Control de Salón</h1>
                    <p class="text-xs text-gray-400">Visualiza y gestiona el estado de las mesas en tiempo real.</p>
                </div>
            </div>

            <!-- CONTADORES SUPERIORES -->
            <div class="flex flex-wrap items-center gap-3">
                <div class="flex items-center gap-2 bg-[#141c2e] p-1.5 rounded-xl border border-slate-800 text-xs">
                    <span class="badge-pill badge-free-bg">
                        <span class="w-2 h-2 rounded-full bg-green-400"></span> DISPONIBLE 
                        <span class="ml-1 text-white">{{ $cntLibres }}</span>
                    </span>
                    <span class="badge-pill badge-occupied-bg">
                        <span class="w-2 h-2 rounded-full bg-red-400"></span> OCUPADA 
                        <span class="ml-1 text-white">{{ $cntOcupadas }}</span>
                    </span>
                    <span class="badge-pill badge-reserved-bg">
                        <span class="w-2 h-2 rounded-full bg-amber-400"></span> RESERVADA 
                        <span class="ml-1 text-white">{{ $cntReservadas }}</span>
                    </span>
                </div>

                <a href="{{ route('orders.delivery') }}" class="px-4 py-2.5 rounded-xl text-xs font-bold btn-blue flex items-center gap-2 shadow-lg shadow-blue-500/20 text-white decoration-none">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                    <span>Delivery</span>
                </a>

                <a href="{{ route('reservations.create') }}" class="px-4 py-2.5 rounded-xl text-xs font-bold btn-orange flex items-center gap-2 shadow-lg shadow-orange-500/20 text-white decoration-none">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    <span>Reservar</span>
                </a>
            </div>
        </div>

        <!-- MAIN LAYOUT -->
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
            
            <!-- PANEL DE MESAS -->
            <div class="lg:col-span-3 panel-card p-5 relative min-h-[580px] flex flex-col justify-between">
                <div>
                    <!-- BARRA CONMUTADORA DE VISTAS -->
                    <div class="flex items-center justify-between border-b border-slate-800 pb-4 mb-5">
                        <div class="flex items-center gap-2 text-sm font-bold text-white">
                            <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                            <span>Mesas del Salón</span>
                        </div>

                        <div class="flex items-center gap-1 bg-[#101726] p-1 rounded-xl border border-slate-800 text-xs">
                            <button @click="vista = 'mapa'" 
                                    :class="vista === 'mapa' ? 'bg-blue-600 text-white font-semibold shadow' : 'text-gray-400 hover:text-white font-medium'"
                                    class="px-3 py-1.5 rounded-lg flex items-center gap-1.5 transition cursor-pointer border-0">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/></svg>
                                Vista de mapa
                            </button>
                            <button @click="vista = 'lista'" 
                                    :class="vista === 'lista' ? 'bg-blue-600 text-white font-semibold shadow' : 'text-gray-400 hover:text-white font-medium'"
                                    class="px-3 py-1.5 rounded-lg flex items-center gap-1.5 transition cursor-pointer border-0">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/></svg>
                                Vista de lista
                            </button>
                        </div>
                    </div>

                    <!-- VISTA DE MAPA INTERACTIVA -->
                    <div x-show="vista === 'mapa'" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-5">
                        @forelse($listaMesas as $mesa)
                            @php
                                $mId = $mesa->id ?? $loop->iteration;
                                $est = strtolower($mesa->estado ?? 'libre');
                                $statusClass = in_array($est, ['libre', 'disponible']) ? 'status-free' : ($est == 'ocupada' ? 'status-occupied' : 'status-reserved');
                                $badgeClass = in_array($est, ['libre', 'disponible']) ? 'badge-free-bg' : ($est == 'ocupada' ? 'badge-occupied-bg' : 'badge-reserved-bg');
                                $fillColor = in_array($est, ['libre', 'disponible']) ? '#22c55e' : ($est == 'ocupada' ? '#ef4444' : '#f7931e');
                                $isRound = $mId % 2 != 0;
                            @endphp

                            <!-- TARJETA CLICABLE -->
                            <a href="{{ url('/mesa/'.$mId) }}" class="table-card {{ $statusClass }} p-4 min-h-[200px]">
                                <span class="absolute top-3 right-3 text-[10px] text-gray-400 font-semibold flex items-center gap-1">
                                    <svg class="w-3 h-3 text-gray-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"/></svg> 
                                    {{ $mesa->capacidad ?? 4 }}
                                </span>

                                <div class="mt-2 mb-2 table-2d self-center">
                                    <svg width="90" height="90" viewBox="0 0 100 100">
                                        @if($isRound)
                                            <circle cx="50" cy="18" r="8" fill="#64748b"/><circle cx="50" cy="82" r="8" fill="#64748b"/><circle cx="18" cy="50" r="8" fill="#64748b"/><circle cx="82" cy="50" r="8" fill="#64748b"/>
                                            <circle cx="50" cy="50" r="30" fill="#a16207" stroke="#78350f" stroke-width="3"/><circle cx="50" cy="50" r="22" fill="{{ $fillColor }}"/>
                                        @else
                                            <rect x="36" y="10" width="28" height="12" rx="4" fill="#64748b"/><rect x="36" y="78" width="28" height="12" rx="4" fill="#64748b"/><rect x="10" y="36" width="12" height="28" rx="4" fill="#64748b"/><rect x="78" y="36" width="12" height="28" rx="4" fill="#64748b"/>
                                            <rect x="22" y="22" width="56" height="56" rx="8" fill="#a16207" stroke="#78350f" stroke-width="3"/><circle cx="50" cy="50" r="18" fill="{{ $fillColor }}"/>
                                        @endif
                                        <text x="50" y="56" font-size="16" font-weight="bold" fill="#ffffff" text-anchor="middle">{{ $mesa->numero ?? $mId }}</text>
                                    </svg>
                                </div>

                                <div class="text-center w-full">
                                    <h3 class="text-sm font-bold text-white mb-1">Mesa {{ $mesa->numero ?? $mId }}</h3>
                                    <span class="badge-pill {{ $badgeClass }} w-full justify-center uppercase">
                                        <span class="w-1.5 h-1.5 rounded-full" style="background-color: {{ $fillColor }}"></span> 
                                        {{ $mesa->estado ?? 'libre' }}
                                    </span>
                                </div>
                            </a>
                        @empty
                            <!-- MESAS INTERACTIVAS POR DEFECTO -->
                            <a href="/mesa/1" class="table-card status-free p-4 min-h-[200px]">
                                <span class="absolute top-3 right-3 text-[10px] text-gray-400 font-semibold flex items-center gap-1">
                                    <svg class="w-3 h-3 text-gray-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"/></svg> 4
                                </span>
                                <div class="mt-2 mb-2 table-2d self-center">
                                    <svg width="90" height="90" viewBox="0 0 100 100">
                                        <circle cx="50" cy="18" r="8" fill="#64748b"/><circle cx="50" cy="82" r="8" fill="#64748b"/><circle cx="18" cy="50" r="8" fill="#64748b"/><circle cx="82" cy="50" r="8" fill="#64748b"/>
                                        <circle cx="50" cy="50" r="30" fill="#a16207" stroke="#78350f" stroke-width="3"/><circle cx="50" cy="50" r="22" fill="#22c55e"/>
                                        <text x="50" y="56" font-size="16" font-weight="bold" fill="#ffffff" text-anchor="middle">1</text>
                                    </svg>
                                </div>
                                <div class="text-center w-full">
                                    <h3 class="text-sm font-bold text-white mb-1">Mesa 1</h3>
                                    <span class="badge-pill badge-free-bg w-full justify-center"><span class="w-1.5 h-1.5 rounded-full bg-green-400"></span> LIBRE</span>
                                </div>
                            </a>

                            <a href="/mesa/2" class="table-card status-occupied p-4 min-h-[200px]">
                                <span class="absolute top-3 right-3 text-[10px] text-gray-400 font-semibold flex items-center gap-1">
                                    <svg class="w-3 h-3 text-gray-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"/></svg> 4
                                </span>
                                <div class="mt-2 mb-2 table-2d self-center">
                                    <svg width="90" height="90" viewBox="0 0 100 100">
                                        <rect x="36" y="10" width="28" height="12" rx="4" fill="#64748b"/><rect x="36" y="78" width="28" height="12" rx="4" fill="#64748b"/><rect x="10" y="36" width="12" height="28" rx="4" fill="#64748b"/><rect x="78" y="36" width="12" height="28" rx="4" fill="#64748b"/>
                                        <rect x="22" y="22" width="56" height="56" rx="8" fill="#a16207" stroke="#78350f" stroke-width="3"/><circle cx="50" cy="50" r="18" fill="#ef4444"/>
                                        <text x="50" y="56" font-size="16" font-weight="bold" fill="#ffffff" text-anchor="middle">2</text>
                                    </svg>
                                </div>
                                <div class="text-center w-full">
                                    <h3 class="text-sm font-bold text-white mb-1">Mesa 2</h3>
                                    <span class="badge-pill badge-occupied-bg w-full justify-center"><span class="w-1.5 h-1.5 rounded-full bg-red-400"></span> OCUPADA</span>
                                </div>
                            </a>

                            <a href="/mesa/3" class="table-card status-free p-4 min-h-[200px]">
                                <span class="absolute top-3 right-3 text-[10px] text-gray-400 font-semibold flex items-center gap-1">
                                    <svg class="w-3 h-3 text-gray-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"/></svg> 2
                                </span>
                                <div class="mt-2 mb-2 table-2d self-center">
                                    <svg width="90" height="90" viewBox="0 0 100 100">
                                        <circle cx="50" cy="18" r="8" fill="#64748b"/><circle cx="50" cy="82" r="8" fill="#64748b"/>
                                        <circle cx="50" cy="50" r="30" fill="#a16207" stroke="#78350f" stroke-width="3"/><circle cx="50" cy="50" r="22" fill="#22c55e"/>
                                        <text x="50" y="56" font-size="16" font-weight="bold" fill="#ffffff" text-anchor="middle">3</text>
                                    </svg>
                                </div>
                                <div class="text-center w-full">
                                    <h3 class="text-sm font-bold text-white mb-1">Mesa 3</h3>
                                    <span class="badge-pill badge-free-bg w-full justify-center"><span class="w-1.5 h-1.5 rounded-full bg-green-400"></span> LIBRE</span>
                                </div>
                            </a>

                            <a href="/mesa/4" class="table-card status-reserved p-4 min-h-[200px]">
                                <span class="absolute top-3 right-3 text-[10px] text-gray-400 font-semibold flex items-center gap-1">
                                    <svg class="w-3 h-3 text-gray-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"/></svg> 6
                                </span>
                                <div class="mt-2 mb-2 table-2d self-center">
                                    <svg width="90" height="90" viewBox="0 0 100 100">
                                        <rect x="36" y="10" width="28" height="12" rx="4" fill="#64748b"/><rect x="36" y="78" width="28" height="12" rx="4" fill="#64748b"/><rect x="10" y="36" width="12" height="28" rx="4" fill="#64748b"/><rect x="78" y="36" width="12" height="28" rx="4" fill="#64748b"/>
                                        <rect x="22" y="22" width="56" height="56" rx="8" fill="#a16207" stroke="#78350f" stroke-width="3"/><circle cx="50" cy="50" r="18" fill="#f7931e"/>
                                        <text x="50" y="56" font-size="16" font-weight="bold" fill="#ffffff" text-anchor="middle">4</text>
                                    </svg>
                                </div>
                                <div class="text-center w-full">
                                    <h3 class="text-sm font-bold text-white mb-1">Mesa 4</h3>
                                    <span class="badge-pill badge-reserved-bg w-full justify-center"><span class="w-1.5 h-1.5 rounded-full bg-amber-400"></span> RESERVADA</span>
                                </div>
                            </a>

                            <a href="/mesa/5" class="table-card status-free p-4 min-h-[200px]">
                                <span class="absolute top-3 right-3 text-[10px] text-gray-400 font-semibold flex items-center gap-1">
                                    <svg class="w-3 h-3 text-gray-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"/></svg> 4
                                </span>
                                <div class="mt-2 mb-2 table-2d self-center">
                                    <svg width="90" height="90" viewBox="0 0 100 100">
                                        <circle cx="50" cy="18" r="8" fill="#64748b"/><circle cx="50" cy="82" r="8" fill="#64748b"/><circle cx="18" cy="50" r="8" fill="#64748b"/><circle cx="82" cy="50" r="8" fill="#64748b"/>
                                        <circle cx="50" cy="50" r="30" fill="#a16207" stroke="#78350f" stroke-width="3"/><circle cx="50" cy="50" r="22" fill="#22c55e"/>
                                        <text x="50" y="56" font-size="16" font-weight="bold" fill="#ffffff" text-anchor="middle">5</text>
                                    </svg>
                                </div>
                                <div class="text-center w-full">
                                    <h3 class="text-sm font-bold text-white mb-1">Mesa 5</h3>
                                    <span class="badge-pill badge-free-bg w-full justify-center"><span class="w-1.5 h-1.5 rounded-full bg-green-400"></span> LIBRE</span>
                                </div>
                            </a>
                        @endforelse
                    </div>

                    <!-- VISTA DE LISTA INTERACTIVA -->
                    <div x-show="vista === 'lista'" x-cloak class="overflow-x-auto">
                        <table class="w-full text-left text-xs text-gray-300">
                            <thead class="bg-[#121a2d] text-gray-400 uppercase font-bold border-b border-slate-800">
                                <tr>
                                    <th class="p-3">Mesa</th>
                                    <th class="p-3">Capacidad</th>
                                    <th class="p-3">Estado</th>
                                    <th class="p-3 text-right">Acción</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-800/60">
                                <tr class="hover:bg-slate-800/30 transition">
                                    <td class="p-3 font-bold text-white">Mesa 1</td>
                                    <td class="p-3">4 personas</td>
                                    <td class="p-3"><span class="badge-pill badge-free-bg"><span class="w-1.5 h-1.5 rounded-full bg-green-400"></span> LIBRE</span></td>
                                    <td class="p-3 text-right"><a href="/mesa/1" class="px-3 py-1.5 bg-blue-600/80 hover:bg-blue-600 text-white font-semibold rounded-lg text-xs decoration-none inline-block">Gestionar</a></td>
                                </tr>
                                <tr class="hover:bg-slate-800/30 transition">
                                    <td class="p-3 font-bold text-white">Mesa 2</td>
                                    <td class="p-3">4 personas</td>
                                    <td class="p-3"><span class="badge-pill badge-occupied-bg"><span class="w-1.5 h-1.5 rounded-full bg-red-400"></span> OCUPADA</span></td>
                                    <td class="p-3 text-right"><a href="/mesa/2" class="px-3 py-1.5 bg-blue-600/80 hover:bg-blue-600 text-white font-semibold rounded-lg text-xs decoration-none inline-block">Ver Pedido</a></td>
                                </tr>
                                <tr class="hover:bg-slate-800/30 transition">
                                    <td class="p-3 font-bold text-white">Mesa 3</td>
                                    <td class="p-3">2 personas</td>
                                    <td class="p-3"><span class="badge-pill badge-free-bg"><span class="w-1.5 h-1.5 rounded-full bg-green-400"></span> LIBRE</span></td>
                                    <td class="p-3 text-right"><a href="/mesa/3" class="px-3 py-1.5 bg-blue-600/80 hover:bg-blue-600 text-white font-semibold rounded-lg text-xs decoration-none inline-block">Gestionar</a></td>
                                </tr>
                                <tr class="hover:bg-slate-800/30 transition">
                                    <td class="p-3 font-bold text-white">Mesa 4</td>
                                    <td class="p-3">6 personas</td>
                                    <td class="p-3"><span class="badge-pill badge-reserved-bg"><span class="w-1.5 h-1.5 rounded-full bg-amber-400"></span> RESERVADA</span></td>
                                    <td class="p-3 text-right"><a href="/mesa/4" class="px-3 py-1.5 bg-blue-600/80 hover:bg-blue-600 text-white font-semibold rounded-lg text-xs decoration-none inline-block">Ver Reserva</a></td>
                                </tr>
                                <tr class="hover:bg-slate-800/30 transition">
                                    <td class="p-3 font-bold text-white">Mesa 5</td>
                                    <td class="p-3">4 personas</td>
                                    <td class="p-3"><span class="badge-pill badge-free-bg"><span class="w-1.5 h-1.5 rounded-full bg-green-400"></span> LIBRE</span></td>
                                    <td class="p-3 text-right"><a href="/mesa/5" class="px-3 py-1.5 bg-blue-600/80 hover:bg-blue-600 text-white font-semibold rounded-lg text-xs decoration-none inline-block">Gestionar</a></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="hidden md:flex items-end justify-end p-2 opacity-25">
                    <div class="text-right">
                        <p class="font-serif italic text-xs text-orange-200">¡Buen servicio, siempre!</p>
                    </div>
                </div>
            </div>

            <!-- RESUMEN DEL SALÓN -->
            <div class="space-y-6">
                <div class="panel-card p-5">
                    <h2 class="text-sm font-bold text-white border-b border-slate-800 pb-3 mb-4">Resumen del salón</h2>
                    <div class="space-y-3.5 text-xs">
                        <div class="flex items-center justify-between">
                            <span class="flex items-center gap-2 text-gray-300">
                                <span class="w-2.5 h-2.5 rounded-full bg-green-400"></span> Disponibles
                            </span>
                            <span class="font-bold text-white">{{ $cntLibres }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="flex items-center gap-2 text-gray-300">
                                <span class="w-2.5 h-2.5 rounded-full bg-red-400"></span> Ocupadas
                            </span>
                            <span class="font-bold text-white">{{ $cntOcupadas }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="flex items-center gap-2 text-gray-300">
                                <span class="w-2.5 h-2.5 rounded-full bg-amber-400"></span> Reservadas
                            </span>
                            <span class="font-bold text-white">{{ $cntReservadas }}</span>
                        </div>
                        <div class="pt-3 border-t border-slate-800 flex items-center justify-between">
                            <span class="flex items-center gap-2 text-gray-400 font-semibold">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg> Total de mesas
                            </span>
                            <span class="font-extrabold text-white text-sm">{{ $cntTotal }}</span>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>