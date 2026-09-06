<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <div class="p-2 bg-indigo-100 dark:bg-orange-900 rounded-lg text-orange-600 dark:text-orange-300">
                <i class="fa-solid fa-map-location-dot text-xl"></i>
            </div>
            <h2 class="text-xl font-bold leading-tight text-gray-800 dark:text-gray-200">
                Centro de Control de Delivery
            </h2>
        </div>
    </x-slot>

    <div class="p-6 max-w-7xl mx-auto">

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

            @forelse($pedidosPendientes as $pedido)
            <div class="relative bg-white dark:bg-dark-eval-1 rounded-xl shadow-md border border-gray-100 dark:border-gray-700 overflow-hidden group hover:shadow-xl transition-all duration-300">

                <div class="absolute top-0 left-0 w-full h-1 {{ $pedido->status == 'en_camino' ? 'bg-yellow-400' : 'bg-blue-500' }}"></div>

                <div class="p-5">
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <div class="flex items-center gap-2 mb-1">
                                <span class="bg-gray-100 dark:bg-gray-700 text-gray-500 dark:text-gray-300 text-[10px] font-black px-2 py-0.5 rounded uppercase tracking-wider">
                                    #{{ $pedido->id }}
                                </span>
                                <span class="flex items-center gap-1 text-xs text-gray-400 font-medium">
                                    <i class="fa-regular fa-clock"></i>
                                    {{ $pedido->created_at->format('H:i') }}
                                </span>
                            </div>
                            <h3 class="text-lg font-bold text-gray-800 dark:text-white leading-tight truncate w-48" title="{{ $pedido->customer->name ?? 'Cliente General' }}">
                                {{ $pedido->customer->name ?? 'Cliente General' }}
                            </h3>
                            <a href="tel:{{ $pedido->customer->phone ?? '' }}" class="text-sm text-gray-500 hover:text-blue-500 transition-colors flex items-center gap-1 mt-1">
                                <i class="fa-solid fa-phone text-xs"></i>
                                {{ $pedido->customer->phone ?? 'Sin Teléfono' }}
                            </a>
                        </div>

                        <div class="flex flex-col items-end">
                            <span class="text-xs text-gray-400 mb-0.5">Total</span>
                            <span class="text-xl font-black text-gray-800 dark:text-white">
                                S/ {{ number_format($pedido->total, 2) }}
                            </span>
                        </div>
                    </div>

                    <div class="mb-5 bg-gray-50 dark:bg-gray-700/50 p-3 rounded-lg border border-gray-100 dark:border-gray-700 flex gap-3 items-start">
                        <div class="mt-1 text-red-500 flex-shrink-0">
                            <i class="fa-solid fa-location-dot"></i>
                        </div>
                        <p class="text-sm text-gray-600 dark:text-gray-300 leading-snug line-clamp-2">
                            {{ $pedido->customer->address ?? 'Recojo en tienda' }}
                        </p>
                    </div>

                    <div class="mb-5">
                        @if($pedido->status == 'en_camino')
                        <div class="flex items-center justify-between p-3 bg-yellow-50 dark:bg-yellow-900/20 rounded-lg border border-yellow-100 dark:border-yellow-800">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-yellow-100 text-yellow-600 flex items-center justify-center shadow-sm">
                                    <i class="fa-solid fa-motorcycle"></i>
                                </div>
                                <div>
                                    <p class="text-xs font-bold text-yellow-700 dark:text-yellow-400 uppercase">En Ruta</p>
                                    <p class="text-sm font-semibold text-gray-700 dark:text-gray-200">{{ $pedido->repartidor->nombre }}</p>
                                </div>
                            </div>
                            <span class="relative flex h-3 w-3">
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-yellow-400 opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-3 w-3 bg-yellow-500"></span>
                            </span>
                        </div>
                        @else
                        <div class="flex items-center gap-3 p-3 bg-blue-50 dark:bg-blue-900/20 rounded-lg border border-blue-100 dark:border-blue-800">
                            <div class="w-8 h-8 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center shadow-sm">
                                <i class="fa-solid fa-fire-burner"></i>
                            </div>
                            <div>
                                <p class="text-xs font-bold text-blue-700 dark:text-blue-400 uppercase">En Cocina / Listo</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">Esperando asignación</p>
                            </div>
                        </div>
                        @endif
                    </div>

                    <div class="pt-4 border-t border-gray-100 dark:border-gray-700">
                        @if($pedido->status != 'en_camino')
                        <form action="{{ route('orders.assign', $pedido->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <label class="block text-[10px] font-bold text-gray-400 uppercase mb-2">Asignar Repartidor</label>
                            <div class="flex gap-2">
                                <div class="relative w-full">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                                        <i class="fa-solid fa-helmet-safety text-xs"></i>
                                    </div>
                                    <select name="repartidor_id" required class="w-full pl-8 py-2 text-sm border-gray-300 rounded-lg dark:bg-dark-eval-2 dark:border-gray-600 dark:text-white focus:ring-blue-500 focus:border-blue-500 appearance-none">
                                        <option value="">Seleccionar...</option>
                                        @foreach($repartidores as $rep)
                                        <option value="{{ $rep->id }}">{{ $rep->nombre }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 rounded-lg shadow-md hover:shadow-lg transition-all transform active:scale-95 flex items-center justify-center">
                                    <i class="fa-solid fa-paper-plane"></i>
                                </button>
                            </div>
                        </form>
                        @else
                        <form action="{{ route('orders.cobrar', $pedido->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="flex flex-col gap-3">
                                <label class="block text-[10px] font-bold text-gray-400 uppercase">
                                    Método de Pago:
                                </label>

                                <div class="grid grid-cols-3 gap-2">
                                    <label class="cursor-pointer">
                                        <input type="radio" name="payment_method" value="efectivo" class="peer sr-only" required>
                                        <div class="flex flex-col items-center justify-center p-2 rounded-lg border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-gray-700/50 text-gray-400 peer-checked:bg-green-100 peer-checked:border-green-500 peer-checked:text-green-600 transition-all hover:bg-gray-100">
                                            <i class="fa-solid fa-money-bill-1-wave text-lg mb-1"></i>
                                            <span class="text-[9px] font-bold uppercase">Efectivo</span>
                                        </div>
                                    </label>

                                    <!-- <label class="cursor-pointer">
                                        <input type="radio" name="payment_method" value="tarjeta" class="peer sr-only">
                                        <div class="flex flex-col items-center justify-center p-2 rounded-lg border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-gray-700/50 text-gray-400 peer-checked:bg-blue-100 peer-checked:border-blue-500 peer-checked:text-blue-600 transition-all hover:bg-gray-100">
                                            <i class="fa-regular fa-credit-card text-lg mb-1"></i>
                                            <span class="text-[9px] font-bold uppercase">Tarjeta</span>
                                        </div>
                                    </label> -->

                                    <label class="cursor-pointer">
                                        <input type="radio" name="payment_method" value="yape" class="peer sr-only">
                                        <div class="flex flex-col items-center justify-center p-2 rounded-lg border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-gray-700/50 text-gray-400 peer-checked:bg-purple-100 peer-checked:border-purple-500 peer-checked:text-purple-600 transition-all hover:bg-gray-100">
                                            <i class="fa-solid fa-qrcode text-lg mb-1"></i>
                                            <span class="text-[9px] font-bold uppercase">Yape</span>
                                        </div>
                                    </label>
                                </div>

                                <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white py-2 rounded-lg shadow-md transition-all active:scale-95 flex items-center justify-center gap-2 font-bold text-sm">
                                    <i class="fa-solid fa-check-circle"></i>
                                    <span>CONFIRMAR ENTREGA</span>
                                </button>
                            </div>
                        </form>
                        @endif
                    </div>
                </div>
            </div>
            @empty
            <div class="col-span-1 md:col-span-2 lg:col-span-3 flex flex-col items-center justify-center py-16 bg-white dark:bg-dark-eval-1 rounded-xl border border-dashed border-gray-300 dark:border-gray-700">
                <div class="bg-gray-50 dark:bg-gray-800 p-4 rounded-full mb-4">
                    <i class="fa-solid fa-person-biking text-4xl text-gray-300"></i>
                </div>
                <h3 class="text-lg font-bold text-gray-500 dark:text-gray-400">No hay pedidos pendientes</h3>
                <p class="text-sm text-gray-400">Los nuevos pedidos de delivery aparecerán aquí.</p>
            </div>
            @endforelse

        </div>
    </div>
</x-app-layout>
