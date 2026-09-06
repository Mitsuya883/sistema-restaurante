<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-2">
            <div class="p-2 bg-orange-100 rounded-lg text-orange-600">
                <i class="fa-solid fa-cash-register text-lg"></i>
            </div>
            <h2 class="text-lg font-bold leading-tight text-gray-800 dark:text-gray-200">
                {{ __('Caja: Cerrar Mesa') }} <span class="text-orange-600 border-b-2 border-orange-500">{{ $table->name }}</span>
            </h2>
        </div>
    </x-slot>

    <div class="p-4 md:p-6 max-w-5xl mx-auto">

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-6 items-start">

            <div class="bg-white dark:bg-dark-eval-1 p-4 md:p-6 rounded-xl shadow-lg border border-gray-200 dark:border-gray-700 relative overflow-hidden">

                <h3 class="flex items-center gap-2 text-base font-bold mb-4 text-gray-700 dark:text-gray-300 border-b border-gray-100 dark:border-gray-700 pb-2">
                    <i class="fa-solid fa-receipt text-orange-500"></i>
                    Detalle de Consumo
                </h3>

                <div class="max-h-[300px] overflow-y-auto pr-1 mb-4 custom-scrollbar">
                    <ul class="space-y-2">
                        @foreach($order->details as $item)
                        <li class="flex justify-between items-start text-sm p-2 bg-gray-50 dark:bg-gray-700/30 rounded border border-gray-100 dark:border-gray-700">
                            <div class="flex items-start gap-2">
                                <span class="mt-0.5 flex-shrink-0 flex items-center justify-center w-5 h-5 bg-white dark:bg-gray-600 rounded text-[10px] font-bold shadow-sm text-gray-500 border border-gray-200 dark:border-gray-500">
                                    {{ $item->quantity }}
                                </span>
                                <span class="text-gray-700 dark:text-gray-300 font-medium leading-tight">
                                    {{ $item->product->name }}
                                </span>
                            </div>
                            <span class="font-bold text-gray-800 dark:text-gray-200 whitespace-nowrap ml-2">
                                S/ {{ number_format($item->price * $item->quantity, 2) }}
                            </span>
                        </li>
                        @endforeach
                    </ul>
                </div>

                <div class="bg-orange-50 dark:bg-gray-800 p-4 rounded-lg border border-orange-100 dark:border-gray-700 border-dashed">
                    <div class="flex justify-between items-center text-gray-500 dark:text-gray-400 text-xs mb-1">
                        <span>Subtotal</span>
                        <span>S/ {{ number_format($order->total / 1.18, 2) }}</span>
                    </div>
                    <div class="flex justify-between items-center text-xl md:text-2xl font-black text-gray-800 dark:text-white">
                        <span>Total</span>
                        <span class="text-orange-600">S/ {{ $order->total }}</span>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-dark-eval-1 p-4 md:p-6 rounded-xl shadow-lg border border-gray-200 dark:border-gray-700">
                <h3 class="flex items-center gap-2 text-base font-bold mb-4 text-gray-700 dark:text-gray-300 border-b border-gray-100 dark:border-gray-700 pb-2">
                    <i class="fa-solid fa-wallet text-green-500"></i>
                    Procesar Pago
                </h3>

                <form action="{{ route('pagos.store') }}" method="POST" target="_blank" data-redirect="{{ route('dashboard') }}" onsubmit="handleRedirect(this)">
                    @csrf
                    <input type="hidden" name="order_id" value="{{ $order->id }}">
                    <input type="hidden" name="amount" value="{{ $order->total }}">

                    <div class="mb-6">
                        <label class="block text-xs font-bold text-gray-500 dark:text-gray-400 mb-2 uppercase">
                            Medio de Pago
                        </label>

                        <div class="grid grid-cols-3 gap-2 md:gap-3">
                            <label class="cursor-pointer relative w-full group">
                                <input type="radio" name="payment_method" value="cash" class="peer sr-only" checked>
                                <div class="h-20 md:h-24 flex flex-col items-center justify-center p-1 border rounded-lg transition-all
                                            bg-white dark:bg-gray-800 border-gray-200 dark:border-gray-600
                                            peer-checked:bg-green-50 dark:peer-checked:bg-green-900/20
                                            peer-checked:border-green-500 peer-checked:text-green-700 dark:peer-checked:text-green-400
                                            peer-checked:shadow-md">
                                    <i class="fa-solid fa-money-bill-wave text-xl md:text-2xl mb-1"></i>
                                    <span class="font-bold text-[10px] md:text-xs text-center leading-none">Efectivo</span>
                                </div>
                            </label>

                            <label class="cursor-pointer relative w-full group">
                                <input type="radio" name="payment_method" value="card" class="peer sr-only">
                                <div class="h-20 md:h-24 flex flex-col items-center justify-center p-1 border rounded-lg transition-all
                                            bg-white dark:bg-gray-800 border-gray-200 dark:border-gray-600
                                            peer-checked:bg-blue-50 dark:peer-checked:bg-blue-900/20
                                            peer-checked:border-blue-500 peer-checked:text-blue-700 dark:peer-checked:text-blue-400
                                            peer-checked:shadow-md">
                                    <i class="fa-solid fa-credit-card text-xl md:text-2xl mb-1"></i>
                                    <span class="font-bold text-[10px] md:text-xs text-center leading-none">Tarjeta</span>
                                </div>
                            </label>

                            <label class="cursor-pointer relative w-full group">
                                <input type="radio" name="payment_method" value="yape" class="peer sr-only">
                                <div class="h-20 md:h-24 flex flex-col items-center justify-center p-1 border rounded-lg transition-all
                                            bg-white dark:bg-gray-800 border-gray-200 dark:border-gray-600
                                            peer-checked:bg-purple-50 dark:peer-checked:bg-purple-900/20
                                            peer-checked:border-purple-500 peer-checked:text-purple-700 dark:peer-checked:text-purple-400
                                            peer-checked:shadow-md">
                                    <i class="fa-solid fa-qrcode text-xl md:text-2xl mb-1"></i>
                                    <span class="font-bold text-[10px] md:text-xs text-center leading-none">Yape</span>
                                </div>
                            </label>
                        </div>
                    </div>

                    <div class="mb-4 bg-gray-50 dark:bg-gray-700/30 p-3 rounded-lg border border-gray-200 dark:border-gray-600"
                        x-data="{ tipoDoc: 'ticket' }">

                        <div class="flex p-1 bg-gray-200 dark:bg-gray-600 rounded mb-3">
                            <label class="flex-1 cursor-pointer">
                                <input type="radio" name="tipo_comprobante" value="ticket" x-model="tipoDoc" class="sr-only peer">
                                <div class="text-center text-[10px] md:text-xs font-bold py-1.5 rounded transition-all text-gray-600 dark:text-gray-300 peer-checked:bg-white dark:peer-checked:bg-dark-eval-1 peer-checked:text-orange-600 peer-checked:shadow-sm">
                                    TICKET
                                </div>
                            </label>
                            <label class="flex-1 cursor-pointer">
                                <input type="radio" name="tipo_comprobante" value="boleta" x-model="tipoDoc" class="sr-only peer">
                                <div class="text-center text-[10px] md:text-xs font-bold py-1.5 rounded transition-all text-gray-600 dark:text-gray-300 peer-checked:bg-white dark:peer-checked:bg-dark-eval-1 peer-checked:text-orange-600 peer-checked:shadow-sm">
                                    BOLETA
                                </div>
                            </label>
                            <label class="flex-1 cursor-pointer">
                                <input type="radio" name="tipo_comprobante" value="factura" x-model="tipoDoc" class="sr-only peer">
                                <div class="text-center text-[10px] md:text-xs font-bold py-1.5 rounded transition-all text-gray-600 dark:text-gray-300 peer-checked:bg-white dark:peer-checked:bg-dark-eval-1 peer-checked:text-orange-600 peer-checked:shadow-sm">
                                    FACTURA
                                </div>
                            </label>
                        </div>

                        <div x-show="tipoDoc !== 'ticket'"
                             class="space-y-2">

                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-2.5 flex items-center pointer-events-none">
                                    <i class="fa-solid fa-id-card text-gray-400 text-xs"></i>
                                </div>
                                <input type="text"
                                    name="nro_documento"
                                    class="w-full pl-8 py-1.5 text-xs rounded border-gray-300 dark:bg-dark-eval-2 dark:border-gray-600 dark:text-gray-200 focus:ring-orange-500 focus:border-orange-500"
                                    :placeholder="tipoDoc === 'factura' ? 'RUC (11 dígitos)' : 'DNI (8 dígitos)'"
                                    :maxlength="tipoDoc === 'factura' ? 11 : 8"
                                    oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                    :required="tipoDoc === 'boleta' || tipoDoc === 'factura'">
                            </div>

                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-2.5 flex items-center pointer-events-none">
                                    <i class="fa-solid fa-user text-gray-400 text-xs"></i>
                                </div>
                                <input type="text"
                                    name="razon_social"
                                    class="w-full pl-8 py-1.5 text-xs rounded border-gray-300 dark:bg-dark-eval-2 dark:border-gray-600 dark:text-gray-200 focus:ring-orange-500 focus:border-orange-500"
                                    :placeholder="tipoDoc === 'factura' ? 'Razón Social' : 'Cliente'"
                                    :required="tipoDoc === 'boleta' || tipoDoc === 'factura'">
                            </div>

                            <div x-show="tipoDoc === 'factura'" class="relative">
                                <div class="absolute inset-y-0 left-0 pl-2.5 flex items-center pointer-events-none">
                                    <i class="fa-solid fa-map-pin text-gray-400 text-xs"></i>
                                </div>
                                <input type="text"
                                    name="direccion_fiscal"
                                    class="w-full pl-8 py-1.5 text-xs rounded border-gray-300 dark:bg-dark-eval-2 dark:border-gray-600 dark:text-gray-200 focus:ring-orange-500 focus:border-orange-500"
                                    placeholder="Dirección Fiscal"
                                    :required="tipoDoc === 'factura'">
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="w-full py-3 bg-gradient-to-r from-green-600 to-green-500 hover:from-green-700 hover:to-green-600 text-white font-bold rounded-xl shadow-lg shadow-green-500/30 text-base transition-all transform hover:-translate-y-0.5 active:scale-95 flex justify-center items-center gap-2">
                        <i class="fa-solid fa-print"></i>
                        <span>COBRAR S/ {{ $order->total }}</span>
                    </button>
                </form>
            </div>

        </div>
    </div>
</x-app-layout>

<script>
    function handleRedirect(form) {
        const dashboardUrl = form.getAttribute('data-redirect');
        setTimeout(function() {
            window.location.href = dashboardUrl;
        }, 1000);
        return true;
    }
</script>
