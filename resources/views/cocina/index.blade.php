<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center gap-4">
            <div class="flex items-center gap-3">
                <div class="p-2 bg-indigo-100 dark:bg-orange-900 rounded-lg text-orange-600 dark:text-orange-300">
                    <i class="fa-solid fa-kitchen-set text-xl"></i>
                </div>
                <h2 class="text-xl font-bold leading-tight text-gray-800 dark:text-gray-200">
                    {{ __('Monitor de Cocina (KDS)') }}
                </h2>
            </div>

            <div class="flex items-center gap-4 text-xs font-bold text-gray-500 bg-white dark:bg-gray-800 px-4 py-2 rounded-full shadow-sm border border-gray-200 dark:border-gray-700">
                <span class="flex items-center gap-1.5"><i class="fa-solid fa-circle text-green-500 text-[8px]"></i> < 15m</span>
                <span class="flex items-center gap-1.5"><i class="fa-solid fa-circle text-yellow-400 text-[8px]"></i> 15-30m</span>
                <span class="flex items-center gap-1.5"><i class="fa-solid fa-circle text-red-600 text-[8px]"></i> > 30m</span>
            </div>

            <a href="{{ route('cocina.index') }}" class="px-4 py-2 bg-gray-800 hover:bg-gray-700 text-white rounded-lg shadow text-sm font-bold flex items-center gap-2 transition-all">
                <i class="fa-solid fa-rotate"></i> Actualizar
            </a>
        </div>
    </x-slot>

    <audio id="alerta-sonido" preload="auto">
        <source src="https://assets.mixkit.co/active_storage/sfx/2869/2869-preview.mp3" type="audio/mpeg">
    </audio>

    <div class="p-6 max-w-[1920px] mx-auto">

        @if($pedidos->isEmpty())
            <div class="flex flex-col items-center justify-center py-24 text-gray-400">
                <i class="fa-solid fa-mug-hot text-6xl mb-4 opacity-20"></i>
                <h3 class="text-xl font-bold">Sin comandas pendientes</h3>
                <p class="text-sm">La cocina está libre.</p>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">

                @foreach($pedidos as $pedido)
                    @php
                        $minutos = $pedido->created_at->diffInMinutes(now());

                        if ($minutos > 30) {
                            $borderColor = 'border-red-500';
                            $bgColorHeader = 'bg-red-50 dark:bg-red-900/30';
                            $textColor = 'text-red-700 dark:text-red-400';
                            $icon = 'fa-fire';
                        } elseif ($minutos > 15) {
                            $borderColor = 'border-yellow-400';
                            $bgColorHeader = 'bg-yellow-50 dark:bg-yellow-900/30';
                            $textColor = 'text-yellow-700 dark:text-yellow-400';
                            $icon = 'fa-clock';
                        } else {
                            $borderColor = 'border-green-500';
                            $bgColorHeader = 'bg-white dark:bg-gray-800'; // Header limpio para nuevos
                            $textColor = 'text-green-700 dark:text-green-400';
                            $icon = 'fa-check';
                        }
                    @endphp

                    <div class="flex flex-col bg-white dark:bg-dark-eval-1 rounded-lg shadow-md border-t-4 {{ $borderColor }} overflow-hidden h-full">

                        <div class="px-4 py-3 border-b border-gray-100 dark:border-gray-700 {{ $bgColorHeader }} flex justify-between items-center">

                            <div class="flex items-center gap-3">
                                <h3 class="text-lg font-black text-gray-800 dark:text-white leading-none">
                                    {{ $pedido->table->name ?? 'Delivery' }}
                                </h3>
                                <span class="text-xs font-mono text-gray-500 bg-white dark:bg-black/20 px-1.5 py-0.5 rounded border border-gray-200 dark:border-gray-600">
                                    #{{ $pedido->id }}
                                </span>
                            </div>

                            <div class="text-right">
                                <div class="text-sm font-bold {{ $textColor }} flex items-center justify-end gap-1.5">
                                    <i class="fa-solid {{ $icon }}"></i>
                                    <span>{{ $pedido->created_at->format('H:i') }}</span>
                                    <span class="text-xs opacity-80">({{ $minutos }}m)</span>
                                </div>
                                <div class="text-[10px] text-gray-400 uppercase font-bold tracking-wider">
                                    {{ $pedido->user->name ?? 'Staff' }}
                                </div>
                            </div>
                        </div>

                        <div class="flex-1 p-0 overflow-y-auto max-h-[400px] custom-scrollbar bg-white dark:bg-dark-eval-1">
                            <table class="w-full">
                                <tbody class="divide-y divide-gray-50 dark:divide-gray-700/50">
                                    @foreach($pedido->orderDetails as $detalle)
                                    <tr class="group hover:bg-gray-50 dark:hover:bg-gray-700/20 transition-colors">
                                        <td class="pl-4 py-2 w-12 align-top">
                                            <div class="flex items-center justify-center w-8 h-8 rounded bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200 font-black text-lg border border-gray-200 dark:border-gray-600">
                                                {{ $detalle->quantity }}
                                            </div>
                                        </td>

                                        <td class="px-3 py-2 align-middle">
                                            <div class="font-bold text-gray-700 dark:text-gray-200 text-base leading-tight">
                                                {{ $detalle->product->name }}
                                            </div>

                                            @if($detalle->note)
                                            <div class="mt-1 flex items-start gap-1.5 text-xs font-bold text-red-500 dark:text-red-400 bg-red-50 dark:bg-red-900/10 px-2 py-1 rounded inline-block max-w-full">
                                                <i class="fa-solid fa-comment-dots mt-0.5"></i>
                                                <span class="uppercase">{{ $detalle->note }}</span>
                                            </div>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="p-3 bg-gray-50 dark:bg-gray-800/50 border-t border-gray-100 dark:border-gray-700">
                            <form action="{{ route('cocina.listo', $pedido->id) }}" method="POST">
                                @csrf
                                <button type="button" onclick="confirmarSalida(this)"
                                    class="w-full py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-black uppercase tracking-widest rounded shadow-sm hover:shadow transition-all flex justify-center items-center gap-2 active:scale-[0.98]">
                                    <i class="fa-solid fa-check"></i>
                                    Listo
                                </button>
                            </form>
                        </div>

                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const countKey = 'pedidos_cocina_count';
            let cantidadActual = parseInt("{{ $pedidos->count() }}");
            let cantidadAnterior = localStorage.getItem(countKey);
            let audio = document.getElementById("alerta-sonido");

            if (cantidadAnterior !== null && cantidadActual > parseInt(cantidadAnterior)) {
                try { audio.play(); } catch (e) {}
            }
            localStorage.setItem(countKey, cantidadActual);
            setTimeout(() => window.location.reload(), 30000);
        });

        function confirmarSalida(btn) {
            btn.innerHTML = '<i class="fa-solid fa-circle-notch fa-spin"></i> PROCESANDO...';
            btn.classList.remove('bg-green-600', 'hover:bg-green-700');
            btn.classList.add('bg-gray-400', 'cursor-not-allowed');

            setTimeout(() => {
                btn.closest('form').submit();
            }, 300);
        }
    </script>
</x-app-layout>
