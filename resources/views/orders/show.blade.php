<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                <i class="fa-solid fa-utensils mr-2 text-orange-500"></i>
                {{ __('Atendiendo: ') }} <span class="text-orange-600 font-bold">{{ $table->name }}</span>
            </h2>
            <div class="text-sm text-gray-500 flex items-center gap-2">
                <span class="flex items-center gap-1"><i class="fa-solid fa-users"></i> {{ $table->capacity }} pers.</span>
                @if($table->status == 'ocupada')
                <span class="ml-2 px-3 py-1 bg-red-100 text-red-700 rounded-full text-xs font-bold border border-red-200">
                    <i class="fa-solid fa-circle text-[8px] mr-1"></i> Ocupada
                </span>
                @else
                <span class="ml-2 px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-bold border border-green-200">
                    <i class="fa-solid fa-circle text-[8px] mr-1"></i> Libre
                </span>
                @endif
            </div>
        </div>
    </x-slot>

    <div x-data="orderSystem()" class="flex flex-col md:flex-row h-[calc(100vh-10rem)] overflow-hidden gap-4 p-4">

        <div class="w-full md:w-2/3 overflow-y-auto pr-2 pb-20 custom-scrollbar">
            @foreach ($categories as $category)
            @if($category->products->count() > 0)
            <h3 class="flex items-center text-lg font-bold text-gray-700 dark:text-gray-300 mb-4 mt-2 border-b border-gray-200 dark:border-gray-700 pb-2">
                <i class="fa-solid fa-layer-group text-orange-500 mr-2 text-sm"></i> {{ $category->name }}
            </h3>

            <div class="grid grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4 mb-8">
                @foreach ($category->products as $product)
                <div @click="addToCart({{ $product->id }}, '{{ $product->name }}', {{ $product->price }})"
                    class="bg-white dark:bg-dark-eval-1 p-4 rounded-xl shadow-sm hover:shadow-lg cursor-pointer border-2 border-transparent hover:border-orange-400 transition-all group relative active:scale-95 flex flex-col justify-between h-full">

                    <div>
                        <div class="flex justify-between items-start mb-2">
                            <span class="bg-gray-100 dark:bg-gray-700 text-xs font-black px-2 py-1 rounded text-gray-600 dark:text-gray-300">
                                S/ {{ $product->price }}
                            </span>
                        </div>
                        <h4 class="font-bold text-gray-800 dark:text-gray-200 leading-tight group-hover:text-orange-600 transition-colors">
                            {{ $product->name }}
                        </h4>
                        <p class="text-xs text-gray-400 mt-2 line-clamp-2">
                            {{ $product->description }}
                        </p>
                    </div>

                    <button class="mt-3 w-full py-2 bg-gray-50 dark:bg-gray-700 hover:bg-orange-600 hover:text-white text-gray-600 dark:text-gray-300 text-xs font-bold rounded-lg transition-colors flex items-center justify-center gap-1">
                        <i class="fa-solid fa-plus"></i> AGREGAR
                    </button>
                </div>
                @endforeach
            </div>
            @endif
            @endforeach
        </div>

        <div class="w-full md:w-1/3 bg-white dark:bg-dark-eval-1 rounded-xl shadow-lg flex flex-col h-full border border-gray-200 dark:border-gray-700">

            @if($table->orders && $table->orders->count() > 0)
            <div class="flex-1 overflow-y-auto bg-yellow-50 dark:bg-yellow-900/10 border-b-4 border-white dark:border-gray-800">
                <div class="sticky top-0 bg-yellow-100 dark:bg-yellow-900/50 p-3 flex justify-between items-center border-b border-yellow-200 dark:border-yellow-800 backdrop-blur-sm z-10">
                    <h3 class="font-bold text-yellow-800 dark:text-yellow-200 text-sm flex items-center gap-2">
                        <i class="fa-solid fa-clock-rotate-left"></i> En Cocina / Entregado
                    </h3>
                    <span class="text-xs font-bold text-yellow-800 dark:text-yellow-200 bg-yellow-200/50 px-2 py-1 rounded">
                        S/ {{ number_format($table->orders->sum('total'), 2) }}
                    </span>
                </div>

                <div class="p-3 space-y-3">
                    @foreach($table->orders as $order)
                    @if($order->orderDetails)
                    @foreach($order->orderDetails as $detail)

                    <div class="flex flex-col sm:flex-row sm:items-center justify-between bg-white dark:bg-gray-800 p-2 rounded-lg border border-yellow-200 dark:border-yellow-800/30 shadow-sm">
                        <div class="flex items-start gap-3 mb-2 sm:mb-0">
                            <span class="flex-shrink-0 flex items-center justify-center w-8 h-8 bg-yellow-100 text-yellow-700 font-bold rounded-full text-xs">
                                x{{ $detail->quantity }}
                            </span>
                            <div class="flex flex-col">
                                <span class="text-sm font-semibold text-gray-700 dark:text-gray-200 leading-tight">
                                    {{ $detail->product->name }}
                                </span>
                                @if($detail->note)
                                <span class="text-[10px] text-gray-400 italic">"{{ $detail->note }}"</span>
                                @endif
                            </div>
                        </div>
                        <div class="text-right pl-11 sm:pl-0">
                            <span class="text-sm font-bold text-gray-600 dark:text-gray-400">
                                S/ {{ number_format($detail->quantity * $detail->price, 2) }}
                            </span>
                        </div>
                    </div>

                    @endforeach
                    @endif
                    @endforeach
                </div>
            </div>
            @endif

            <div class="p-3 border-b border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 flex justify-between items-center shadow-sm z-20">
                <h3 class="font-bold text-gray-700 dark:text-gray-200 flex items-center gap-2">
                    <i class="fa-solid fa-cart-plus text-orange-500"></i> Nuevo Pedido
                </h3>
                <span class="text-xs bg-orange-100 text-orange-700 px-2 py-1 rounded-full font-bold border border-orange-200 transition-all transform scale-100" x-show="cart.length > 0" x-transition>
                    <span x-text="cart.length"></span> items
                </span>
            </div>

            <div class="flex-1 p-3 overflow-y-auto bg-gray-50 dark:bg-dark-eval-2">
                <div x-show="cart.length === 0" class="flex flex-col items-center justify-center h-full text-gray-400 min-h-[150px]">
                    <i class="fa-solid fa-basket-shopping text-4xl mb-3 opacity-30"></i>
                    <p class="text-xs font-medium">Selecciona platos del menú</p>
                </div>

                <template x-for="(item, index) in cart" :key="index">
                    <div class="mb-3 p-3 bg-white dark:bg-dark-eval-1 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 animate-fade-in-down group">

                        <div class="flex justify-between items-start gap-2 mb-2">
                            <div class="flex-1">
                                <h5 class="text-sm font-bold text-gray-800 dark:text-gray-200 leading-tight" x-text="item.name"></h5>
                                <div class="text-[10px] text-gray-400 mt-1">
                                    Unitario: S/ <span x-text="item.price"></span>
                                </div>
                            </div>

                            <button @click="removeFromCart(index)" class="text-gray-300 hover:text-red-500 transition-colors p-1" title="Quitar item">
                                <i class="fa-solid fa-trash-can"></i>
                            </button>
                        </div>

                        <div class="flex justify-between items-center mt-3">

                            <div class="flex items-center bg-gray-100 dark:bg-gray-700 rounded-lg p-1 shadow-inner">
                                <button
                                    @click="decreaseQty(index)"
                                    class="w-7 h-7 flex items-center justify-center bg-white dark:bg-gray-600 rounded text-orange-500 hover:text-orange-700 shadow-sm transition active:scale-95 disabled:opacity-50"
                                    :disabled="item.quantity <= 1">
                                    <i class="fa-solid fa-minus text-xs"></i>
                                </button>

                                <span class="w-8 text-center text-sm font-bold text-gray-700 dark:text-gray-200" x-text="item.quantity"></span>

                                <button
                                    @click="increaseQty(index)"
                                    class="w-7 h-7 flex items-center justify-center bg-white dark:bg-gray-600 rounded text-orange-500 hover:text-orange-700 shadow-sm transition active:scale-95">
                                    <i class="fa-solid fa-plus text-xs"></i>
                                </button>
                            </div>

                            <span class="font-bold text-gray-700 dark:text-gray-300 text-sm">
                                S/ <span x-text="(item.price * item.quantity).toFixed(2)"></span>
                            </span>
                        </div>

                        <div class="mt-3 pt-2 border-t border-gray-100 dark:border-gray-700">
                            <div class="relative">
                                <i class="fa-solid fa-pen absolute left-0 top-2 text-[10px] text-gray-400"></i>
                                <input
                                    type="text"
                                    x-model="item.note"
                                    placeholder="Nota de cocina (Ej: Sin picante...)"
                                    class="w-full text-xs border-0 border-b border-gray-200 dark:border-gray-600 bg-transparent focus:ring-0 focus:border-orange-500 pl-4 py-1 text-gray-600 dark:text-gray-300 placeholder-gray-400">
                            </div>
                        </div>

                    </div>
                </template>
            </div>

            <div class="p-4 bg-white dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700 rounded-b-xl z-20 shadow-[0_-5px_15px_rgba(0,0,0,0.05)]">

                <div class="flex justify-between items-center mb-4">
                    <span class="text-sm text-gray-500 font-medium">Total Pedido Nuevo:</span>
                    <span class="text-2xl font-black text-gray-800 dark:text-white tracking-tight">S/ <span x-text="total"></span></span>
                </div>

                <form id="orderForm" method="POST" action="{{ route('orders.store') }}" @submit.prevent="submitOrder">
                    @csrf

                    <input type="hidden" name="table_id" value="{{ $table->id }}">
                    <input type="hidden" name="cart_data" :value="JSON.stringify(cart)">
                    <input type="hidden" name="total" :value="total">

                    <input type="hidden" name="tipo_comprobante" value="ticket">
                    <input type="hidden" name="client_name" value="Mesa {{ $table->name }}">

                    <div class="grid grid-cols-3 gap-3">
                        <button type="button" @click="cart = []; updateTotal()"
                            class="col-span-1 py-3 rounded-xl font-bold text-xs bg-red-50 text-red-500 hover:bg-red-100 border border-red-200 transition-colors flex flex-col items-center justify-center gap-1">
                            <i class="fa-solid fa-trash"></i>
                            LIMPIAR
                        </button>

                        <button type="submit"
                            id="btnEnviar"
                            class="col-span-2 bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white py-3 rounded-xl font-bold text-sm shadow-lg shadow-green-500/30 transition-all transform hover:-translate-y-0.5 disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center gap-2"
                            :disabled="cart.length === 0">

                            <span class="btn-text">ENVIAR A COCINA</span>
                            <i class="fa-solid fa-paper-plane btn-icon"></i>

                            <svg class="animate-spin h-5 w-5 text-white hidden btn-spinner" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                        </button>
                    </div>
                </form>

                @if($table->status == 'ocupada' || ($table->orders && $table->orders->count() > 0))
                <div class="mt-4 pt-4 border-t border-gray-200 dark:border-gray-700 border-dashed">
                    <div class="flex justify-between items-end mb-2">
                        <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Cuenta Acumulada</span>
                    </div>
                    <a href="{{ route('pagos.show', $table->id) }}" class="flex items-center justify-between w-full py-3 px-4 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl shadow-lg shadow-blue-600/30 transition-all group">
                        <span class="flex items-center gap-2">
                            <i class="fa-solid fa-cash-register"></i> COBRAR
                        </span>
                        <span class="bg-blue-800 px-2 py-1 rounded text-sm">
                            S/ {{ number_format($table->orders->sum('total'), 2) }}
                        </span>
                    </a>
                </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
<input type="hidden" id="session-status" value="{{ session('status') }}">
<input type="hidden" id="session-error" value="{{ session('error') }}">
<input type="hidden" id="session-errors" value="{{ $errors->any() ? json_encode($errors->all()) : '' }}">
<script>
    function orderSystem() {
        return {
            cart: [],
            total: '0.00',

            addToCart(id, name, price) {
                let existingItem = this.cart.find(item => item.id === id);
                if (existingItem) { existingItem.quantity++; }
                else { this.cart.push({ id: id, name: name, price: price, quantity: 1, note: '' }); }
                this.updateTotal();
            },
            increaseQty(index) { this.cart[index].quantity++; this.updateTotal(); },
            decreaseQty(index) { if (this.cart[index].quantity > 1) { this.cart[index].quantity--; this.updateTotal(); } },
            removeFromCart(index) { this.cart.splice(index, 1); this.updateTotal(); },
            updateTotal() {
                let sum = this.cart.reduce((acc, item) => acc + (item.price * item.quantity), 0);
                this.total = sum.toFixed(2);
            },

            submitOrder(e) {
                const btn = document.getElementById('btnEnviar');
                const spinner = btn.querySelector('.btn-spinner');
                const text = btn.querySelector('.btn-text');
                const icon = btn.querySelector('.btn-icon');

                btn.disabled = true;
                text.textContent = "ENVIANDO...";
                icon.classList.add('hidden');
                spinner.classList.remove('hidden');

                document.getElementById('orderForm').submit();
            }
        }
    }

    document.addEventListener('DOMContentLoaded', function() {

        const statusVal = document.getElementById('session-status').value;
        const errorVal = document.getElementById('session-error').value;
        const errorsJson = document.getElementById('session-errors').value;

        if (statusVal) {
            Swal.fire({
                icon: 'success',
                title: '¡Operación Exitosa!',
                text: statusVal,
                showConfirmButton: false,
                timer: 2000,
                background: document.body.classList.contains('dark') ? '#1f2937' : '#fff',
                color: document.body.classList.contains('dark') ? '#fff' : '#000'
            });
        }

        if (errorVal) {
            Swal.fire({
                icon: 'error',
                title: 'Ocurrió un error',
                text: errorVal,
                confirmButtonColor: '#d33'
            });
        }

        if (errorsJson) {
            try {
                const errorsArray = JSON.parse(errorsJson);
                if (errorsArray.length > 0) {
                    let listaHtml = '<ul style="text-align: left; font-size: 0.9em; margin-left: 20px;">';
                    errorsArray.forEach(function(err) {
                        listaHtml += '<li>• ' + err + '</li>';
                    });
                    listaHtml += '</ul>';

                    Swal.fire({
                        icon: 'warning',
                        title: 'Faltan datos',
                        html: listaHtml,
                        confirmButtonColor: '#f59e0b'
                    });
                }
            } catch (e) {
                console.error("Error al leer JSON de validaciones", e);
            }
        }
    });
</script>
