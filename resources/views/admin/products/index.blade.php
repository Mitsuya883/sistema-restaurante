<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center gap-4">
            <h2 class="text-xl font-bold leading-tight text-gray-800 dark:text-gray-200 flex items-center gap-2">
                <div class="p-2 bg-orange-100 dark:bg-orange-900 rounded-lg text-orange-600 dark:text-orange-300">
                    <i class="fa-solid fa-utensils"></i>
                </div>
                Gestión de Platos
            </h2>

            <div class="flex items-center gap-3 w-full md:w-auto">
                <form method="GET" action="{{ route('admin.products.index') }}" class="relative w-full md:w-64">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                        <i class="fa-solid fa-search"></i>
                    </div>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Buscar plato..."
                        class="w-full pl-10 pr-4 py-2 text-sm border-gray-200 dark:border-gray-700 rounded-lg bg-white dark:bg-dark-eval-2 text-gray-700 dark:text-gray-200 focus:ring-2 focus:ring-orange-500/50 focus:border-orange-500 transition-all shadow-sm">
                </form>

                <a href="{{ route('admin.products.create') }}" class="bg-gradient-to-r from-orange-600 to-orange-500 hover:from-orange-700 hover:to-orange-600 text-white px-4 py-2 rounded-lg text-sm font-bold shadow-md hover:shadow-lg transition-all transform hover:-translate-y-0.5 flex items-center gap-2 whitespace-nowrap">
                    <i class="fa-solid fa-plus"></i> Nuevo Plato
                </a>
            </div>
        </div>
    </x-slot>

    <div class="p-6 max-w-7xl mx-auto">

        @if(request('search'))
        <div class="mb-4 flex items-center gap-2 text-sm text-gray-500">
            <span>Resultados para: <strong>"{{ request('search') }}"</strong></span>
            <a href="{{ route('admin.products.index') }}" class="text-red-500 hover:text-red-700 font-bold hover:underline ml-2 flex items-center gap-1">
                <i class="fa-solid fa-circle-xmark"></i> Limpiar filtro
            </a>
        </div>
        @endif

        <div class="bg-white dark:bg-dark-eval-1 overflow-hidden shadow-xl rounded-2xl border border-gray-100 dark:border-gray-700">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-800/50">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-black text-gray-400 uppercase tracking-wider">Detalle del Plato</th>
                            <th class="px-6 py-4 text-left text-xs font-black text-gray-400 uppercase tracking-wider">Categoría</th>
                            <th class="px-6 py-4 text-left text-xs font-black text-gray-400 uppercase tracking-wider">Precio</th>
                            <th class="px-6 py-4 text-center text-xs font-black text-gray-400 uppercase tracking-wider">Disponibilidad</th>
                            <th class="px-6 py-4 text-right text-xs font-black text-gray-400 uppercase tracking-wider">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-700 bg-white dark:bg-dark-eval-1">
                        @forelse($products as $product)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/30 transition-colors group">

                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center gap-4">
                                        <!-- <div class="flex-shrink-0 h-12 w-12 rounded-xl overflow-hidden shadow-sm border border-gray-100 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 flex items-center justify-center">
                                            @if($product->image)
                                                <img src="{{ asset('storage/' . $product->image) }}" class="h-full w-full object-cover">
                                            @else
                                                <i class="fa-solid fa-image text-gray-300 text-xl"></i>
                                            @endif
                                        </div> -->
                                        <div>
                                            <div class="text-sm font-bold text-gray-900 dark:text-white">{{ $product->name }}</div>
                                            <div class="text-xs text-gray-500 dark:text-gray-400 line-clamp-1 max-w-[200px]" title="{{ $product->description }}">
                                                {{ $product->description }}
                                            </div>
                                        </div>
                                    </div>
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-bold bg-blue-50 text-blue-700 dark:bg-blue-900/30 dark:text-blue-300 border border-blue-100 dark:border-blue-800">
                                        <i class="fa-solid fa-layer-group text-[10px]"></i>
                                        {{ $product->category->name }}
                                    </span>
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-black text-gray-800 dark:text-gray-200">
                                        S/ {{ number_format($product->price, 2) }}
                                    </div>
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <form action="{{ route('admin.productos.toggle', $product->id) }}" method="POST" class="inline-block">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="relative inline-flex items-center cursor-pointer group focus:outline-none" title="Cambiar disponibilidad">
                                            <div class="w-10 h-5 rounded-full shadow-inner transition-colors duration-300 ease-in-out {{ $product->disponible_hoy ? 'bg-green-500' : 'bg-gray-300 dark:bg-gray-600' }}"></div>
                                            <div class="absolute left-0.5 top-0.5 bg-white w-4 h-4 rounded-full shadow transform transition-transform duration-300 ease-in-out {{ $product->disponible_hoy ? 'translate-x-5' : '' }}"></div>
                                        </button>
                                    </form>
                                    <div class="mt-1 text-[10px] font-bold uppercase tracking-wide {{ $product->disponible_hoy ? 'text-green-600' : 'text-gray-400' }}">
                                        {{ $product->disponible_hoy ? 'En Menú' : 'Oculto' }}
                                    </div>
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex items-center justify-end gap-2 opacity-80 group-hover:opacity-100 transition-opacity">

                                        <a href="{{ route('admin.products.edit', $product) }}"
                                           class="w-8 h-8 rounded-full bg-indigo-50 text-indigo-600 hover:bg-indigo-100 hover:text-indigo-700 flex items-center justify-center transition-all hover:scale-110 shadow-sm border border-indigo-200"
                                           title="Editar Plato">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </a>

                                        <form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="inline-block">
                                            @csrf @method('DELETE')
                                            <button type="submit"
                                                    onclick="confirmarBorrado(event, '{{ $product->name }}')"
                                                    class="w-8 h-8 rounded-full bg-red-50 text-red-600 hover:bg-red-100 hover:text-red-700 flex items-center justify-center transition-all hover:scale-110 shadow-sm border border-red-200"
                                                    title="Eliminar Plato">
                                                <i class="fa-solid fa-trash-can"></i>
                                            </button>
                                        </form>

                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                                    <div class="flex flex-col items-center justify-center">
                                        <i class="fa-solid fa-plate-wheat text-4xl mb-3 opacity-30"></i>
                                        <p class="font-medium">No se encontraron platos.</p>
                                        <p class="text-xs mt-1">¡Agrega el primero a tu menú!</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="px-6 py-4 border-t border-gray-100 dark:border-gray-700 bg-gray-50 dark:bg-gray-800/50">
                {{ $products->links() }}
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const successMessage = "{{ session('status') }}";
            if (successMessage) {
                Swal.fire({
                    title: '¡Operación Exitosa!',
                    text: successMessage,
                    icon: 'success',
                    confirmButtonColor: '#F97316',
                    timer: 2000,
                    showConfirmButton: false
                });
            }
        });

        function confirmarBorrado(event, nombrePlato) {
            event.preventDefault();
            const form = event.target.closest('form');

            Swal.fire({
                title: '¿Eliminar Plato?',
                text: "Vas a eliminar '" + nombrePlato + "'. Esta acción no se puede deshacer.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#EF4444',
                cancelButtonColor: '#9CA3AF',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        }
    </script>
</x-app-layout>
