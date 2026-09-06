<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                <!-- <i class="fa-solid fa-store mr-2 text-primary-500"></i> -->
                {{ __('Control de Salón') }}
            </h2>

            <div class="flex flex-wrap gap-2">
                <span class="inline-flex items-center gap-1.5 px-3 py-1 text-xs font-bold rounded-full bg-green-100 text-green-700 dark:bg-green-900 dark:text-green-300 border border-green-200 dark:border-green-800">
                    <i class="fa-solid fa-circle text-[8px]"></i> DISPONIBLE
                </span>
                <span class="inline-flex items-center gap-1.5 px-3 py-1 text-xs font-bold rounded-full bg-red-100 text-red-700 dark:bg-red-900 dark:text-red-300 border border-red-200 dark:border-red-800">
                    <i class="fa-solid fa-circle text-[8px]"></i> OCUPADA
                </span>
                <span class="inline-flex items-center gap-1.5 px-3 py-1 text-xs font-bold rounded-full bg-orange-100 text-orange-700 dark:bg-orange-900 dark:text-orange-300 border border-orange-200 dark:border-orange-800">
                    <i class="fa-solid fa-circle text-[8px]"></i> RESERVADA
                </span>
            </div>

            <div class="flex justify-end gap-3">
                <a href="{{ route('orders.delivery') }}"
                    class="flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg shadow-lg hover:shadow-blue-500/30 transition-all transform hover:-translate-y-0.5 focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 dark:focus:ring-offset-gray-800">
                    <i class="fa-solid fa-motorcycle"></i>
                    <span>Delivery</span>
                </a>

                <a href="{{ route('reservations.create') }}"
                    class="flex items-center gap-2 bg-orange-600 hover:bg-orange-700 text-white font-bold py-2 px-4 rounded-lg shadow-lg hover:shadow-orange-500/30 transition-all transform hover:-translate-y-0.5 focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 dark:focus:ring-offset-gray-800">
                    <i class="fa-solid fa-calendar-plus w-5 text-center"></i>
                    <span>Reservar</span>
                </a>
            </div>
        </div>
    </x-slot>

    <div class="p-6">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">

            @foreach ($tables as $table)
            @php
            $statusData = match($table->status) {
            'libre' => [
            'text' => 'LIBRE',
            'fa_icon' => 'fa-chair',
            'card_classes' => 'border-b-4 border-green-500 hover:shadow-green-500/20',
            'icon_color' => 'text-green-500',
            'bg_badge' => 'bg-green-100 text-green-700 dark:bg-green-900 dark:text-green-300 ring-1 ring-green-500/20'
            ],
            'ocupada' => [
            'text' => 'OCUPADA',
            'fa_icon' => 'fa-utensils',
            'card_classes' => 'border-b-4 border-red-500 hover:shadow-red-500/20',
            'icon_color' => 'text-red-500',
            'bg_badge' => 'bg-red-100 text-red-700 dark:bg-red-900 dark:text-red-300 ring-1 ring-red-500/20'
            ],
            'reservada' => [
            'text' => 'RESERVADA',
            'fa_icon' => 'fa-clock',
            'card_classes' => 'border-b-4 border-orange-400 hover:shadow-orange-500/20',
            'icon_color' => 'text-orange-500',
            'bg_badge' => 'bg-orange-100 text-orange-800 dark:bg-orange-900 dark:text-orange-300 ring-1 ring-orange-500/20'
            ],
            };
            @endphp

            <a href="{{ route('orders.show', $table->id) }}" class="block group">
                <div class="relative bg-white dark:bg-dark-eval-1 rounded-xl shadow-md transition-all duration-300 transform hover:-translate-y-1 hover:shadow-xl overflow-hidden {{ $statusData['card_classes'] }}">

                    <div class="absolute top-3 right-3 flex items-center gap-1 text-xs font-semibold text-gray-400 dark:text-gray-500 bg-gray-50 dark:bg-dark-eval-2 px-2 py-1 rounded-lg">
                        <i class="fa-solid fa-user-group"></i>
                        <span>{{ $table->capacity }}</span>
                    </div>

                    <div class="p-6 flex flex-col items-center justify-center h-48 gap-3">

                        <div class="w-16 h-16 rounded-full flex items-center justify-center bg-gray-50 dark:bg-dark-eval-2 group-hover:scale-110 transition-transform duration-300">
                            <i class="fa-solid {{ $statusData['fa_icon'] }} text-3xl {{ $statusData['icon_color'] }}"></i>
                        </div>

                        <h3 class="text-xl font-bold text-gray-800 dark:text-gray-200 tracking-tight">
                            {{ $table->name }}
                        </h3>

                        <span class="px-3 py-1 rounded-full text-[10px] font-black tracking-widest uppercase shadow-sm {{ $statusData['bg_badge'] }}">
                            {{ $statusData['text'] }}
                        </span>
                    </div>

                    <div class="absolute inset-0 bg-gradient-to-t from-white/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none"></div>
                </div>
            </a>
            @endforeach

        </div>
    </div>
</x-app-layout>
