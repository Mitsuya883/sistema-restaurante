<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                <i class="fa-solid fa-motorcycle mr-2 text-orange-500"></i>
                {{ __('Nuevo Pedido: ') }} <span class="text-orange-600 font-bold">Delivery</span>
            </h2>
            <div class="text-sm text-gray-500">
                <span class="px-3 py-1 bg-blue-50 text-green-600 rounded-full text-xs font-bold border border-blue-200">
                    <i class="fa-solid fa-headset mr-1"></i> Tomando Pedido Whastapp
                </span>
            </div>
        </div>
    </x-slot>

    <div x-data="orderSystem()" class="flex flex-col lg:flex-row h-[calc(100vh-10rem)] overflow-hidden gap-4 p-4">

        <div class="w-full lg:w-2/3 overflow-y-auto pr-2 pb-20 custom-scrollbar">
            @foreach ($categories as $category)
            @if($category->products->count() > 0)
            <h3 class="flex items-center text-lg font-bold text-gray-700 dark:text-gray-300 mb-4 mt-2 border-b border-gray-200 dark:border-gray-700 pb-2">
                <i class="fa-solid fa-layer-group text-orange-500 mr-2 text-sm"></i> {{ $category->name }}
            </h3>

            <div class="grid grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-4 mb-8">
                @foreach ($category->products as $product)
                <div @click="addToCart({{ $product->id }}, '{{ $product->name }}', {{ $product->price }})"
                    class="bg-white dark:bg-dark-eval-1 p-4 rounded-xl shadow-sm hover:shadow-lg cursor-pointer border-2 border-transparent hover:border-orange-400 transition-all group relative active:scale-95 flex flex-col justify-between h-full">

                    <div>
                        <div class="flex justify-between items-start mb-2">
                            <span class="bg-gray-100 dark:bg-gray-700 text-xs font-black px-2 py-1 rounded text-gray-600 dark:text-gray-300">
                                S/ {{ $product->price }}
                            </span>
                        </div>
                        <h4 class="font-bold text-gray-800 dark:text-gray-200 leading-tight group-hover:text-orange-600 transition-colors text-sm">
                            {{ $product->name }}
                        </h4>
                        <p class="text-[10px] text-gray-400 mt-2 line-clamp-2">
                            {{ $product->description }}
                        </p>
                    </div>

                    <button class="mt-3 w-full py-1.5 bg-gray-50 dark:bg-gray-700 hover:bg-orange-600 hover:text-white text-gray-600 dark:text-gray-300 text-xs font-bold rounded-lg transition-colors flex items-center justify-center gap-1">
                        <i class="fa-solid fa-plus"></i> AGREGAR
                    </button>
                </div>
                @endforeach
            </div>
            @endif
            @endforeach
        </div>

        <div class="w-full lg:w-1/3 bg-white dark:bg-dark-eval-1 rounded-xl shadow-lg flex flex-col h-full border border-gray-200 dark:border-gray-700 overflow-hidden">

            <form id="orderForm" method="POST" action="{{ route('orders.store') }}" @submit.prevent="submitOrder" class="flex flex-col h-full">
                @csrf
                <input type="hidden" name="cart_data" :value="JSON.stringify(cart)">
                <input type="hidden" name="total" :value="total">
                <input type="hidden" name="order_type" value="delivery">
                <input type="hidden" name="tipo_comprobante" value="ticket">
                <div class="p-4 bg-blue-50 dark:bg-blue-900/10 border-b border-blue-100 dark:border-blue-800">
                    <h3 class="font-bold text-blue-800 dark:text-blue-300 mb-3 flex items-center gap-2 text-sm uppercase">
                        <i class="fa-solid fa-address-book"></i> Datos de Entrega
                    </h3>

                    <div class="space-y-2">
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400 group-focus-within:text-blue-500">
                                <i class="fa-solid fa-phone text-xs"></i>
                            </div>
                            <input type="tel" name="client_phone" placeholder="Teléfono / Celular" required
                                class="w-full pl-8 py-1.5 text-sm border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-800 dark:text-white focus:ring-blue-500 focus:border-blue-500 shadow-sm transition-colors">
                        </div>

                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400 group-focus-within:text-blue-500">
                                <i class="fa-solid fa-user text-xs"></i>
                            </div>
                            <input type="text" name="client_name" placeholder="Nombre del Cliente" required
                                class="w-full pl-8 py-1.5 text-sm border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-800 dark:text-white focus:ring-blue-500 focus:border-blue-500 shadow-sm transition-colors">
                        </div>

                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400 group-focus-within:text-blue-500">
                                <i class="fa-solid fa-map-location-dot text-xs"></i>
                            </div>
                            <input type="text" name="client_address" placeholder="Dirección exacta (Calle, Nro, Urb)" required
                                class="w-full pl-8 py-1.5 text-sm border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-800 dark:text-white focus:ring-blue-500 focus:border-blue-500 shadow-sm transition-colors">
                        </div>

                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-3 pt-2 pointer-events-none text-gray-400 group-focus-within:text-blue-500">
                                <i class="fa-solid fa-diamond-turn-right text-xs"></i>
                            </div>
                            <textarea name="delivery_reference" rows="2" placeholder="Referencia (Ej: Portón negro, frente al parque...)"
                                class="w-full pl-8 py-1.5 text-sm border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-800 dark:text-white focus:ring-blue-500 focus:border-blue-500 shadow-sm resize-none transition-colors"></textarea>
                        </div>
                    </div>
                </div>

                <div class="p-3 bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center shadow-sm">
                    <h3 class="font-bold text-gray-700 dark:text-gray-200 flex items-center gap-2 text-sm">
                        <i class="fa-solid fa-cart-shopping text-orange-500"></i> Carrito
                    </h3>
                    <span class="text-xs bg-orange-100 text-orange-700 px-2 py-0.5 rounded-full font-bold border border-orange-200 transition-all transform scale-100" x-show="cart.length > 0" x-text="cart.length + ' items'"></span>
                </div>

                <div class="flex-1 p-3 overflow-y-auto bg-gray-50 dark:bg-dark-eval-2 custom-scrollbar">

                    <div x-show="cart.length === 0" class="flex flex-col items-center justify-center h-full text-gray-400 min-h-[100px] opacity-60">
                        <i class="fa-solid fa-basket-shopping text-3xl mb-2"></i>
                        <p class="text-xs font-medium">Agrega productos</p>
                    </div>

                    <template x-for="(item, index) in cart" :key="index">
                        <div class="mb-2 p-2 bg-white dark:bg-dark-eval-1 rounded-lg shadow-sm border border-gray-100 dark:border-gray-700 animate-fade-in-down group">
                            <div class="flex justify-between items-start gap-2 mb-2">
                                <div class="flex-1">
                                    <h5 class="text-sm font-bold text-gray-800 dark:text-gray-200 leading-tight" x-text="item.name"></h5>
                                    <div class="text-[10px] text-gray-400 mt-0.5">
                                        Unit: S/ <span x-text="item.price"></span>
                                    </div>
                                </div>
                                <button type="button" @click="removeFromCart(index)" class="text-gray-300 hover:text-red-500 transition-colors p-1" title="Quitar">
                                    <i class="fa-solid fa-trash-can text-xs"></i>
                                </button>
                            </div>

                            <div class="flex justify-between items-center">
                                <div class="flex items-center bg-gray-100 dark:bg-gray-700 rounded-md p-0.5">
                                    <button type="button" @click="decreaseQty(index)" class="w-6 h-6 flex items-center justify-center bg-white dark:bg-gray-600 rounded text-orange-500 hover:text-orange-700 shadow-sm transition active:scale-95 disabled:opacity-50" :disabled="item.quantity <= 1">
                                        <i class="fa-solid fa-minus text-[10px]"></i>
                                    </button>
                                    <span class="w-8 text-center text-xs font-bold text-gray-700 dark:text-gray-200" x-text="item.quantity"></span>
                                    <button type="button" @click="increaseQty(index)" class="w-6 h-6 flex items-center justify-center bg-white dark:bg-gray-600 rounded text-orange-500 hover:text-orange-700 shadow-sm transition active:scale-95">
                                        <i class="fa-solid fa-plus text-[10px]"></i>
                                    </button>
                                </div>
                                <span class="font-bold text-gray-700 dark:text-gray-300 text-sm">
                                    S/ <span x-text="(item.price * item.quantity).toFixed(2)"></span>
                                </span>
                            </div>

                            <div class="mt-2 pt-1 border-t border-gray-50 dark:border-gray-700">
                                <input type="text" x-model="item.note" placeholder="Nota de cocina..." class="w-full text-[10px] border-0 border-b border-gray-200 dark:border-gray-600 bg-transparent focus:ring-0 focus:border-orange-500 px-0 py-0.5 text-gray-600 dark:text-gray-300 placeholder-gray-400">
                            </div>
                        </div>
                    </template>
                </div>

                <div class="p-4 bg-white dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700 rounded-b-xl shadow-lg z-10">
                    <div class="flex justify-between items-center mb-3">
                        <span class="text-sm text-gray-500 font-medium">Total Delivery:</span>
                        <span class="text-2xl font-black text-gray-800 dark:text-white tracking-tight">S/ <span x-text="total"></span></span>
                    </div>

                    <div class="grid grid-cols-3 gap-2">
                        <button type="button" @click="cart = []; updateTotal()"
                            class="col-span-1 py-3 rounded-xl font-bold text-[10px] md:text-xs bg-red-50 text-red-500 hover:bg-red-100 border border-red-200 transition-colors flex flex-col items-center justify-center gap-1">
                            <i class="fa-solid fa-trash"></i>
                            LIMPIAR
                        </button>

                        <button type="submit" id="btnEnviar"
                            class="col-span-2 bg-gradient-to-r from-blue-600 to-blue-500 hover:from-blue-700 hover:to-blue-600 text-white py-3 rounded-xl font-bold text-sm shadow-lg shadow-blue-500/30 transition-all transform hover:-translate-y-0.5 disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center gap-2"
                            :disabled="cart.length === 0">
                            <span class="btn-text">CONFIRMAR PEDIDO</span>
                            <i class="fa-solid fa-motorcycle btn-icon"></i>
                        </button>
                    </div>
                </div>
            </form>

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

            // Lógica del Carrito (Mantenida igual)
            addToCart(id, name, price) {
                let existingItem = this.cart.find(item => item.id === id);
                if (existingItem) {
                    existingItem.quantity++;
                } else {
                    this.cart.push({
                        id: id,
                        name: name,
                        price: price,
                        quantity: 1,
                        note: ''
                    });
                }
                this.updateTotal();
            },
            increaseQty(index) {
                this.cart[index].quantity++;
                this.updateTotal();
            },
            decreaseQty(index) {
                if (this.cart[index].quantity > 1) {
                    this.cart[index].quantity--;
                    this.updateTotal();
                }
            },
            removeFromCart(index) {
                this.cart.splice(index, 1);
                this.updateTotal();
            },
            updateTotal() {
                let sum = this.cart.reduce((acc, item) => acc + (item.price * item.quantity), 0);
                this.total = sum.toFixed(2);
            },

            // == LÓGICA DE ENVÍO CORREGIDA ==
            submitOrder(e) {
                const form = document.getElementById('orderForm');

                // 1. Validar Campos Requeridos (Nombre, Teléfono, etc.)
                if (!form.checkValidity()) {
                    form.reportValidity(); // Muestra el mensaje "Rellena este campo" nativo
                    return;
                }

                // 2. Validar que haya productos
                if (this.cart.length === 0) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Carrito vacío',
                        text: 'Debes agregar al menos un producto.'
                    });
                    return;
                }

                // 3. Mostrar Alerta de "Cargando..."
                Swal.fire({
                    title: 'Enviando a Cocina...',
                    html: 'Registrando datos del delivery',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                // 4. Enviar formulario
                form.submit();
            }
        }
    }

    // == NOTIFICACIONES AL RECARGAR ==
    document.addEventListener('DOMContentLoaded', function() {
        const statusVal = document.getElementById('session-status').value;
        const errorVal = document.getElementById('session-error').value;
        const errorsJson = document.getElementById('session-errors').value;

        // Éxito
        if (statusVal) {
            Swal.fire({
                icon: 'success',
                title: '¡Delivery Registrado!',
                text: statusVal,
                showConfirmButton: false,
                timer: 2000
            });
        }
        // Error General
        if (errorVal) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: errorVal
            });
        }
        // Faltan Datos
        if (errorsJson) {
            try {
                const errors = JSON.parse(errorsJson);
                if (errors.length > 0) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Faltan datos',
                        text: errors[0]
                    });
                }
            } catch (e) {}
        }
    });
</script>
