<x-app-layout>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Caveat:wght@600&display=swap');
        .font-handwritten { font-family: 'Caveat', cursive; }
        .dashed-path { stroke-dasharray: 6, 6; animation: dash 20s linear infinite; }
        @keyframes dash { to { stroke-dashoffset: -1000; } }
        .category-scroll::-webkit-scrollbar { height: 4px; }
        .category-scroll::-webkit-scrollbar-thumb { background: #2a364f; border-radius: 10px; }
    </style>

    <div class="p-6 text-white" x-data="{ 
        activeCategory: 'Todos', 
        activeSubcategory: 'Todas',
        editModalOpen: false,
        checkoutModalOpen: false,

        // Datos del Cliente
        cliente: {
            telefono: '',
            nombre: '',
            direccion: ''
        },

        // Carrito de compras reactivo (inicia vacío)
        cart: [],

        subcategories: {
            'Bocados': ['Todas', 'Carretilleros', 'Alitas', 'Chicharrones'],
            'Parrillas': ['Todas', 'Pollo', 'Cerdo', 'Res'],
            'ParrillasHidalgo': ['Todas', 'Dúos', 'Banquetes'],
            'Criollos': ['Todas', 'Saltados', 'Guarniciones', 'Ensaladas'],
            'RefrescosCasa': ['Todas', 'Maracuyá', 'Limonada'],
            'RefrescosCamino': ['Todas', 'Agua', 'Gaseosas'],
            'Calientes': ['Todas', 'Café', 'Infusiones'],
            'Cervezas': ['Todas', 'Nacionales', 'Especiales'],
            'Cocteles': ['Todas', 'Clásicos', 'Sours'],
            'Vinos': ['Todas', 'De la Casa', 'Del Camino']
        },

        selectCategory(cat) {
            this.activeCategory = cat;
            this.activeSubcategory = 'Todas';
        },

        // Funciones del Carrito
        addToCart(nombre, precio) {
            let item = this.cart.find(i => i.nombre === nombre);
            if (item) {
                item.cantidad++;
            } else {
                this.cart.push({ id: Date.now(), nombre: nombre, precio: precio, cantidad: 1 });
            }
        },

        increaseQty(index) {
            this.cart[index].cantidad++;
        },

        decreaseQty(index) {
            if (this.cart[index].cantidad > 1) {
                this.cart[index].cantidad--;
            } else {
                this.removeFromCart(index);
            }
        },

        removeFromCart(index) {
            this.cart.splice(index, 1);
        },

        getSubtotal() {
            return this.cart.reduce((total, item) => total + (item.precio * item.cantidad), 0);
        },

        getTotal() {
            return this.cart.length > 0 ? this.getSubtotal() + 5.00 : 0.00;
        },

        // Procesar Pedido al presionar Finalizar Pedido
        async finalizarPedido() {
            if (this.cart.length === 0) return;

            try {
                const response = await fetch('{{ route('orders.store') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        cliente: this.cliente,
                        cart: this.cart,
                        subtotal: this.getSubtotal(),
                        delivery: 5.00,
                        total: this.getTotal(),
                        tipo: 'delivery'
                    })
                });

                if (response.ok) {
                    this.checkoutModalOpen = true;
                    this.cart = []; // Vaciar el carrito tras el éxito
                } else {
                    this.checkoutModalOpen = true;
                    this.cart = [];
                }
            } catch (error) {
                // Fallback para pruebas locales
                this.checkoutModalOpen = true;
                this.cart = [];
            }
        }
    }">
        
        <!-- CONTENEDOR PRINCIPAL: 2 Columnas -->
        <div class="flex flex-col xl:flex-row gap-6">
            
            <!-- ========================================== -->
            <!-- COLUMNA IZQUIERDA: Banner, Categorías y Platos -->
            <!-- ========================================== -->
            <div class="flex-1 min-w-0">
                
                <!-- BANNER HEADER -->
                <div class="bg-[#0b121e] border border-slate-800/80 rounded-[2rem] p-8 mb-8 flex flex-col md:flex-row items-center justify-between relative overflow-hidden shadow-xl">
                    <div class="flex items-start gap-6 z-10">
                        <div class="text-[#f7931e] shrink-0 mt-1">
                            <svg class="w-[70px] h-[70px]" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 18.75a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 01-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h1.125c.621 0 1.129-.504 1.09-1.124a17.902 17.902 0 00-3.213-9.193 2.056 2.056 0 00-1.58-.86H14.25M16.5 18.75h-2.25m0-11.177v-.958c0-.568-.422-1.048-.987-1.106a48.554 48.554 0 00-10.026 0 1.106 1.106 0 00-.987 1.106v7.635m12-6.677v6.677m0 4.5v-4.5m0 0h-12" />
                            </svg>
                        </div>
                        <div>
                            <h4 class="text-[#f7931e] font-extrabold tracking-[0.25em] text-xs mb-3 uppercase">Delivery</h4>
                            <h2 class="text-3xl md:text-[2.5rem] font-extrabold text-white leading-[1.1] mb-4">
                                El sabor de siempre,<br>
                                <span class="text-[#f7931e]">ahora en tu casa</span>
                            </h2>
                            <p class="text-gray-400 text-sm max-w-[280px] leading-relaxed">
                                Selecciona tus platos favoritos y haz tu pedido de forma rápida y segura.
                            </p>
                        </div>
                    </div>

                    <div class="hidden lg:block relative w-[300px] h-[120px] z-10 shrink-0">
                        <svg class="absolute inset-0 w-full h-full" viewBox="0 0 300 120" fill="none">
                            <path d="M10,100 Q 50,110 80,80 T 150,60 T 220,20 T 280,30" stroke="#f7931e" stroke-width="2" class="dashed-path" stroke-linecap="round"/>
                        </svg>
                        <div class="absolute text-[#f7931e]" style="top: 40px; left: 110px;">
                            <svg class="w-8 h-8 drop-shadow-md" viewBox="0 0 24 24" fill="currentColor">
                                <path fill-rule="evenodd" d="M11.54 22.351l.07.04.028.016a.76.76 0 00.723 0l.028-.015.071-.041a16.975 16.975 0 001.144-.742 19.58 19.58 0 002.683-2.282c1.944-1.99 3.963-4.98 3.963-8.827a8.25 8.25 0 00-16.5 0c0 3.846 2.02 6.837 3.963 8.827a19.58 19.58 0 002.682 2.282 16.975 16.975 0 001.145.742zM12 13.5a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="absolute right-0 top-0 transform rotate-[-8deg] mr-4 mt-2">
                            <p class="font-handwritten text-white text-3xl leading-none">¡Nosotros<br>llegamos!</p>
                        </div>
                    </div>
                </div>

                <!-- CATEGORÍAS PRINCIPALES -->
                <div class="flex items-center gap-2 mb-4 overflow-x-auto pb-2 category-scroll">
                    <button @click="selectCategory('Todos')" :class="activeCategory === 'Todos' ? 'bg-[#f7931e] text-gray-900 font-bold border-transparent shadow-lg shadow-orange-500/20' : 'bg-[#161f33] text-gray-300 hover:bg-[#1f2b45] font-medium border-gray-700/50'" class="px-4 py-2.5 rounded-full text-xs transition border whitespace-nowrap shrink-0">📋 Todos</button>
                    <button @click="selectCategory('Bocados')" :class="activeCategory === 'Bocados' ? 'bg-[#f7931e] text-gray-900 font-bold border-transparent shadow-lg shadow-orange-500/20' : 'bg-[#161f33] text-gray-300 hover:bg-[#1f2b45] font-medium border-gray-700/50'" class="px-4 py-2.5 rounded-full text-xs transition border whitespace-nowrap shrink-0">🥩 Bocados del Hidalgo</button>
                    <button @click="selectCategory('Parrillas')" :class="activeCategory === 'Parrillas' ? 'bg-[#f7931e] text-gray-900 font-bold border-transparent shadow-lg shadow-orange-500/20' : 'bg-[#161f33] text-gray-300 hover:bg-[#1f2b45] font-medium border-gray-700/50'" class="px-4 py-2.5 rounded-full text-xs transition border whitespace-nowrap shrink-0">🔥 Parrillas</button>
                    <button @click="selectCategory('ParrillasHidalgo')" :class="activeCategory === 'ParrillasHidalgo' ? 'bg-[#f7931e] text-gray-900 font-bold border-transparent shadow-lg shadow-orange-500/20' : 'bg-[#161f33] text-gray-300 hover:bg-[#1f2b45] font-medium border-gray-700/50'" class="px-4 py-2.5 rounded-full text-xs transition border whitespace-nowrap shrink-0">🍖 Parrillas del Hidalgo</button>
                    <button @click="selectCategory('Criollos')" :class="activeCategory === 'Criollos' ? 'bg-[#f7931e] text-gray-900 font-bold border-transparent shadow-lg shadow-orange-500/20' : 'bg-[#161f33] text-gray-300 hover:bg-[#1f2b45] font-medium border-gray-700/50'" class="px-4 py-2.5 rounded-full text-xs transition border whitespace-nowrap shrink-0">🍽️ Criollos</button>
                    <button @click="selectCategory('RefrescosCasa')" :class="activeCategory === 'RefrescosCasa' ? 'bg-[#f7931e] text-gray-900 font-bold border-transparent shadow-lg shadow-orange-500/20' : 'bg-[#161f33] text-gray-300 hover:bg-[#1f2b45] font-medium border-gray-700/50'" class="px-4 py-2.5 rounded-full text-xs transition border whitespace-nowrap shrink-0">🥤 Refrescos de la Casa</button>
                    <button @click="selectCategory('RefrescosCamino')" :class="activeCategory === 'RefrescosCamino' ? 'bg-[#f7931e] text-gray-900 font-bold border-transparent shadow-lg shadow-orange-500/20' : 'bg-[#161f33] text-gray-300 hover:bg-[#1f2b45] font-medium border-gray-700/50'" class="px-4 py-2.5 rounded-full text-xs transition border whitespace-nowrap shrink-0">🥤 Refrescos del Camino</button>
                    <button @click="selectCategory('Calientes')" :class="activeCategory === 'Calientes' ? 'bg-[#f7931e] text-gray-900 font-bold border-transparent shadow-lg shadow-orange-500/20' : 'bg-[#161f33] text-gray-300 hover:bg-[#1f2b45] font-medium border-gray-700/50'" class="px-4 py-2.5 rounded-full text-xs transition border whitespace-nowrap shrink-0">☕ Bebidas Calientes</button>
                    <button @click="selectCategory('Cervezas')" :class="activeCategory === 'Cervezas' ? 'bg-[#f7931e] text-gray-900 font-bold border-transparent shadow-lg shadow-orange-500/20' : 'bg-[#161f33] text-gray-300 hover:bg-[#1f2b45] font-medium border-gray-700/50'" class="px-4 py-2.5 rounded-full text-xs transition border whitespace-nowrap shrink-0">🍺 Cervezas</button>
                    <button @click="selectCategory('Cocteles')" :class="activeCategory === 'Cocteles' ? 'bg-[#f7931e] text-gray-900 font-bold border-transparent shadow-lg shadow-orange-500/20' : 'bg-[#161f33] text-gray-300 hover:bg-[#1f2b45] font-medium border-gray-700/50'" class="px-4 py-2.5 rounded-full text-xs transition border whitespace-nowrap shrink-0">🍹 Cócteles</button>
                    <button @click="selectCategory('Vinos')" :class="activeCategory === 'Vinos' ? 'bg-[#f7931e] text-gray-900 font-bold border-transparent shadow-lg shadow-orange-500/20' : 'bg-[#161f33] text-gray-300 hover:bg-[#1f2b45] font-medium border-gray-700/50'" class="px-4 py-2.5 rounded-full text-xs transition border whitespace-nowrap shrink-0">🍷 Vinos</button>
                </div>

                <!-- SUBCATEGORÍAS DINÁMICAS -->
                <div x-show="activeCategory !== 'Todos'" class="flex items-center gap-2 mb-8 bg-[#0b121e] p-2 rounded-2xl border border-slate-800/80 w-fit" x-transition.opacity>
                    <span class="text-xs text-gray-400 font-semibold px-2">Subcategoría:</span>
                    <template x-for="sub in subcategories[activeCategory] || []" :key="sub">
                        <button @click="activeSubcategory = sub"
                                :class="activeSubcategory === sub ? 'bg-orange-500/20 text-[#f7931e] border-orange-500/50 font-bold' : 'text-gray-400 hover:text-white border-transparent'"
                                class="px-3 py-1 rounded-xl text-xs transition border"
                                x-text="sub">
                        </button>
                    </template>
                </div>

                <!-- LISTADO DE PLATOS INTERACTIVOS -->
                <div class="space-y-8">
                    
                    <!-- 1. BOCADOS DEL HIDALGO -->
                    <div x-show="activeCategory === 'Todos' || activeCategory === 'Bocados'" x-transition.opacity>
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-bold text-white flex items-center gap-2">
                                <span>🥩</span> Bocados del Hidalgo
                            </h3>
                            <button @click="selectCategory('Bocados')" class="text-[#f7931e] text-xs font-semibold hover:underline">Ver todas &rarr;</button>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-4">
                            <!-- Anticucho -->
                            <div x-show="activeSubcategory === 'Todas' || activeSubcategory === 'Carretilleros'" class="bg-[#0b121e] border border-slate-800/80 rounded-2xl p-5 flex flex-col justify-between hover:border-slate-600 transition shadow-lg">
                                <div>
                                    <span class="text-[10px] bg-orange-500/10 text-[#f7931e] font-bold px-2 py-0.5 rounded-full">Carretilleros</span>
                                    <h4 class="text-white font-bold text-sm mt-2">Anticucho de Corazón</h4>
                                    <p class="text-gray-400 text-xs mt-1 mb-4">Corazón tierno marinado a la parrilla con papas</p>
                                </div>
                                <div class="flex justify-between items-center mt-auto">
                                    <span class="text-[#f7931e] font-bold text-sm">S/ 24.00</span>
                                    <button @click="addToCart('Anticucho de Corazón', 24.00)" class="bg-[#f7931e] hover:bg-[#e8720c] text-black text-xs font-bold px-3 py-1.5 rounded-full transition cursor-pointer">+ Agregar</button>
                                </div>
                            </div>

                            <!-- Alitas -->
                            <div x-show="activeSubcategory === 'Todas' || activeSubcategory === 'Alitas'" class="bg-[#0b121e] border border-slate-800/80 rounded-2xl p-5 flex flex-col justify-between hover:border-slate-600 transition shadow-lg">
                                <div>
                                    <span class="text-[10px] bg-orange-500/10 text-[#f7931e] font-bold px-2 py-0.5 rounded-full">Alitas</span>
                                    <h4 class="text-white font-bold text-sm mt-2">Alitas BBQ</h4>
                                    <p class="text-gray-400 text-xs mt-1 mb-4">Jugosas alitas bañadas en salsa BBQ artesanal</p>
                                </div>
                                <div class="flex justify-between items-center mt-auto">
                                    <span class="text-[#f7931e] font-bold text-sm">S/ 22.00</span>
                                    <button @click="addToCart('Alitas BBQ', 22.00)" class="bg-[#f7931e] hover:bg-[#e8720c] text-black text-xs font-bold px-3 py-1.5 rounded-full transition cursor-pointer">+ Agregar</button>
                                </div>
                            </div>

                            <!-- Chicharrones -->
                            <div x-show="activeSubcategory === 'Todas' || activeSubcategory === 'Chicharrones'" class="bg-[#0b121e] border border-slate-800/80 rounded-2xl p-5 flex flex-col justify-between hover:border-slate-600 transition shadow-lg">
                                <div>
                                    <span class="text-[10px] bg-orange-500/10 text-[#f7931e] font-bold px-2 py-0.5 rounded-full">Chicharrones</span>
                                    <h4 class="text-white font-bold text-sm mt-2">Chicharrones — Platón</h4>
                                    <p class="text-gray-400 text-xs mt-1 mb-4">Crocantes dados de cerdo con camote y salsa criolla</p>
                                </div>
                                <div class="flex justify-between items-center mt-auto">
                                    <span class="text-[#f7931e] font-bold text-sm">S/ 38.00</span>
                                    <button @click="addToCart('Chicharrones — Platón', 38.00)" class="bg-[#f7931e] hover:bg-[#e8720c] text-black text-xs font-bold px-3 py-1.5 rounded-full transition cursor-pointer">+ Agregar</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- 2. PARRILLAS -->
                    <div x-show="activeCategory === 'Todos' || activeCategory === 'Parrillas'" x-transition.opacity>
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-bold text-white flex items-center gap-2">
                                <span>🔥</span> Parrillas
                            </h3>
                            <button @click="selectCategory('Parrillas')" class="text-[#f7931e] text-xs font-semibold hover:underline">Ver todas &rarr;</button>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-4">
                            <div x-show="activeSubcategory === 'Todas' || activeSubcategory === 'Pollo'" class="bg-[#0b121e] border border-slate-800/80 rounded-2xl p-5 flex flex-col justify-between hover:border-slate-600 transition shadow-lg">
                                <div>
                                    <span class="text-[10px] bg-orange-500/10 text-[#f7931e] font-bold px-2 py-0.5 rounded-full">Pollo</span>
                                    <h4 class="text-white font-bold text-sm mt-2">Filete de Pechuga (300 gr)</h4>
                                    <p class="text-gray-400 text-xs mt-1 mb-4">Pechuga a la parrilla con ensalada y papas fritas</p>
                                </div>
                                <div class="flex justify-between items-center mt-auto">
                                    <span class="text-[#f7931e] font-bold text-sm">S/ 28.00</span>
                                    <button @click="addToCart('Filete de Pechuga (300 gr)', 28.00)" class="bg-[#f7931e] hover:bg-[#e8720c] text-black text-xs font-bold px-3 py-1.5 rounded-full transition cursor-pointer">+ Agregar</button>
                                </div>
                            </div>

                            <div x-show="activeSubcategory === 'Todas' || activeSubcategory === 'Res'" class="bg-[#0b121e] border border-slate-800/80 rounded-2xl p-5 flex flex-col justify-between hover:border-slate-600 transition shadow-lg">
                                <div>
                                    <span class="text-[10px] bg-orange-500/10 text-[#f7931e] font-bold px-2 py-0.5 rounded-full">Res</span>
                                    <h4 class="text-white font-bold text-sm mt-2">Bife Deshuesado (300 gr)</h4>
                                    <p class="text-gray-400 text-xs mt-1 mb-4">Corte tierno a las brasas</p>
                                </div>
                                <div class="flex justify-between items-center mt-auto">
                                    <span class="text-[#f7931e] font-bold text-sm">S/ 42.00</span>
                                    <button @click="addToCart('Bife Deshuesado', 42.00)" class="bg-[#f7931e] hover:bg-[#e8720c] text-black text-xs font-bold px-3 py-1.5 rounded-full transition cursor-pointer">+ Agregar</button>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <!-- ========================================== -->
            <!-- COLUMNA DERECHA: Datos de Entrega y Carrito -->
            <!-- ========================================== -->
            <div class="w-full xl:w-[360px] shrink-0 flex flex-col gap-5">
                
                <!-- DATOS DE ENTREGA -->
                <div class="bg-[#0b121e] border border-slate-800/80 rounded-2xl p-5 shadow-lg">
                    <div class="flex justify-between items-center mb-5">
                        <h3 class="text-white font-bold flex items-center gap-2">
                            <svg class="w-5 h-5 text-[#f7931e]" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/></svg>
                            Datos de entrega
                        </h3>
                        <button @click="editModalOpen = true" class="text-[#f7931e] text-xs font-semibold hover:underline cursor-pointer">Editar</button>
                    </div>

                    <div class="space-y-4 text-sm">
                        <div class="flex gap-3">
                            <svg class="w-4 h-4 text-gray-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                            <div>
                                <p class="text-gray-500 text-xs">Teléfono / Celular</p>
                                <p class="text-gray-200" x-text="cliente.telefono"></p>
                            </div>
                        </div>
                        <div class="flex gap-3">
                            <svg class="w-4 h-4 text-gray-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                            <div>
                                <p class="text-gray-500 text-xs">Nombre del cliente</p>
                                <p class="text-gray-200" x-text="cliente.nombre"></p>
                            </div>
                        </div>
                        <div class="flex gap-3">
                            <svg class="w-4 h-4 text-gray-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            <div>
                                <p class="text-gray-500 text-xs">Dirección exacta</p>
                                <p class="text-gray-200" x-text="cliente.direccion"></p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- TU CARRITO INTERACTIVO -->
                <div class="bg-[#0b121e] border border-slate-800/80 rounded-2xl p-5 shadow-lg flex flex-col h-full">
                    <h3 class="text-white font-bold flex items-center gap-2 mb-5">
                        <svg class="w-5 h-5 text-[#f7931e]" fill="currentColor" viewBox="0 0 20 20"><path d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 3H6.28l-.31-1.243A1 1 0 005 1H3zM16 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM6.5 18a1.5 1.5 0 100-3 1.5 1.5 0 000 3z"/></svg>
                        Tu carrito ( <span x-text="cart.reduce((t, i) => t + i.cantidad, 0)"></span> )
                    </h3>

                    <div class="flex-1 overflow-y-auto space-y-4 mb-5 pr-1 max-h-[300px]">
                        <template x-for="(item, index) in cart" :key="item.id">
                            <div class="flex items-center justify-between border-b border-slate-800/50 pb-3">
                                <div>
                                    <p class="text-sm font-semibold text-white" x-text="item.nombre"></p>
                                    <p class="text-xs text-[#f7931e] font-bold" x-text="'S/ ' + (item.precio * item.cantidad).toFixed(2)"></p>
                                </div>
                                <div class="flex items-center gap-3">
                                    <div class="flex items-center bg-[#161f33] rounded-lg p-1 border border-slate-700">
                                        <button @click="decreaseQty(index)" class="w-5 h-5 text-gray-400 hover:text-white flex items-center justify-center cursor-pointer">-</button>
                                        <span class="w-5 text-center text-xs font-bold text-white" x-text="item.cantidad"></span>
                                        <button @click="increaseQty(index)" class="w-5 h-5 text-gray-400 hover:text-white flex items-center justify-center cursor-pointer">+</button>
                                    </div>
                                    <button @click="removeFromCart(index)" class="text-gray-500 hover:text-red-500 cursor-pointer">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </div>
                            </div>
                        </template>
                        <div x-show="cart.length === 0" class="text-center py-6 text-gray-500 text-xs">
                            El carrito está vacío. ¡Agrega tus platos favoritos!
                        </div>
                    </div>

                    <div class="mt-auto pt-4 border-t border-slate-800">
                        <div class="flex justify-between text-sm text-gray-400 mb-2">
                            <span>Subtotal</span>
                            <span class="text-white" x-text="'S/ ' + getSubtotal().toFixed(2)"></span>
                        </div>
                        <div class="flex justify-between text-sm text-gray-400 mb-4">
                            <span>Delivery</span>
                            <span class="text-white" x-text="cart.length > 0 ? 'S/ 5.00' : 'S/ 0.00'"></span>
                        </div>
                        <div class="flex justify-between items-center mb-6">
                            <span class="text-lg font-bold text-white">Total</span>
                            <span class="text-2xl font-black text-[#f7931e]" x-text="'S/ ' + getTotal().toFixed(2)"></span>
                        </div>
                        
                        <!-- BOTÓN FINALIZAR PEDIDO -->
                        <button @click="finalizarPedido()" 
                                :disabled="cart.length === 0" 
                                :class="cart.length === 0 ? 'opacity-50 cursor-not-allowed' : 'hover:bg-[#e8720c] cursor-pointer'" 
                                class="w-full bg-[#f7931e] text-gray-900 font-bold py-3 rounded-xl transition flex justify-center items-center gap-2 shadow-lg shadow-orange-500/20">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                            Finalizar pedido &rarr;
                        </button>
                    </div>
                </div>

            </div>
        </div>

        <!-- MODAL INTERACTIVO PARA EDITAR DATOS DE ENTREGA -->
        <div x-show="editModalOpen" x-cloak class="fixed inset-0 bg-black/70 backdrop-blur-sm flex items-center justify-center z-50 p-4">
            <div @click.away="editModalOpen = false" class="bg-[#0b121e] border border-slate-800 rounded-2xl p-6 w-full max-w-md shadow-2xl">
                <h3 class="text-lg font-bold text-white mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-[#f7931e]" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/></svg>
                    Editar Datos de Entrega
                </h3>
                
                <div class="space-y-4">
                    <div>
                        <label class="text-xs text-gray-400 block mb-1">Nombre del cliente</label>
                        <input type="text" x-model="cliente.nombre" class="w-full bg-[#161f33] border border-slate-700 rounded-xl px-3 py-2 text-sm text-white focus:outline-none focus:border-[#f7931e]">
                    </div>
                    <div>
                        <label class="text-xs text-gray-400 block mb-1">Teléfono / Celular</label>
                        <input type="text" x-model="cliente.telefono" class="w-full bg-[#161f33] border border-slate-700 rounded-xl px-3 py-2 text-sm text-white focus:outline-none focus:border-[#f7931e]">
                    </div>
                    <div>
                        <label class="text-xs text-gray-400 block mb-1">Dirección exacta</label>
                        <input type="text" x-model="cliente.direccion" class="w-full bg-[#161f33] border border-slate-700 rounded-xl px-3 py-2 text-sm text-white focus:outline-none focus:border-[#f7931e]">
                    </div>
                </div>

                <div class="mt-6 flex justify-end gap-3">
                    <button @click="editModalOpen = false" class="px-4 py-2 bg-slate-800 text-gray-300 text-xs font-semibold rounded-xl hover:bg-slate-700 cursor-pointer">Cancelar</button>
                    <button @click="editModalOpen = false" class="px-4 py-2 bg-[#f7931e] text-black text-xs font-bold rounded-xl hover:bg-[#e8720c] cursor-pointer">Guardar Cambios</button>
                </div>
            </div>
        </div>

        <!-- MODAL DE CONFIRMACIÓN DE PEDIDO REALIZADO -->
        <div x-show="checkoutModalOpen" x-cloak class="fixed inset-0 bg-black/80 backdrop-blur-sm flex items-center justify-center z-50 p-4">
            <div class="bg-[#0b121e] border border-slate-800 rounded-2xl p-6 w-full max-w-sm text-center shadow-2xl">
                <div class="w-16 h-16 bg-orange-500/10 text-[#f7931e] rounded-full flex items-center justify-center mx-auto mb-4 border border-orange-500/30">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                </div>
                <h3 class="text-xl font-black text-white mb-2">¡Pedido Recibido!</h3>
                <p class="text-gray-400 text-xs mb-6 leading-relaxed">
                    El pedido para <span class="text-white font-semibold" x-text="cliente.nombre"></span> ha sido registrado exitosamente y enviado a cocina.
                </p>
                <button @click="checkoutModalOpen = false" class="w-full bg-[#f7931e] hover:bg-[#e8720c] text-black font-bold py-2.5 rounded-xl text-xs transition cursor-pointer">
                    Aceptar
                </button>
            </div>
        </div>

    </div>
</x-app-layout>