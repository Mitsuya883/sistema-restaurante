<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <div class="p-2 bg-orange-100 dark:bg-orange-900 rounded-lg text-orange-600 dark:text-orange-300">
                <i class="fa-solid fa-tags text-xl"></i>
            </div>
            <h2 class="text-xl font-bold leading-tight text-gray-800 dark:text-gray-200">
                {{ __('Gestión de Categorías') }}
            </h2>
        </div>
    </x-slot>

    <div class="p-6 max-w-7xl mx-auto">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">

            <div class="lg:col-span-1 sticky top-6">
                <div class="bg-white dark:bg-dark-eval-1 rounded-2xl shadow-lg border border-gray-100 dark:border-gray-700 overflow-hidden">

                    <div class="p-5 border-b border-gray-100 dark:border-gray-700 bg-orange-50 dark:bg-orange-900/10 flex items-center gap-2">
                        <div class="bg-white dark:bg-gray-800 p-1.5 rounded-full shadow-sm">
                            <i class="fa-solid fa-plus text-orange-500 text-xs"></i>
                        </div>
                        <h3 class="font-bold text-gray-800 dark:text-gray-200">Nueva Categoría</h3>
                    </div>

                    <form action="{{ route('admin.categorias.store') }}" method="POST" class="p-6">
                        @csrf

                        <div class="mb-6">
                            <label class="block text-xs font-bold text-gray-500 dark:text-gray-400 mb-1.5 ml-1 uppercase tracking-wide">
                                Nombre de la Categoría
                            </label>
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400 group-focus-within:text-orange-500">
                                    <i class="fa-solid fa-tag"></i>
                                </div>
                                <input type="text" name="name" placeholder="Ej: Entradas, Bebidas..." required
                                    class="w-full pl-10 py-3 text-sm border-gray-200 dark:border-gray-600 rounded-xl bg-gray-50 dark:bg-dark-eval-2 text-gray-800 dark:text-gray-200 focus:ring-2 focus:ring-orange-500/50 focus:border-orange-500 transition-all shadow-sm placeholder-gray-400">
                            </div>
                            @error('name')
                                <p class="mt-1 text-xs text-red-500 flex items-center gap-1">
                                    <i class="fa-solid fa-circle-exclamation"></i> {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <button type="submit"
                            class="w-full py-3 bg-gradient-to-r from-orange-600 to-orange-500 hover:from-orange-700 hover:to-orange-600 text-white rounded-xl shadow-md hover:shadow-lg font-bold transition-all transform hover:-translate-y-0.5 flex items-center justify-center gap-2">
                            <i class="fa-solid fa-floppy-disk"></i>
                            Guardar Categoría
                        </button>
                    </form>
                </div>

                <div class="mt-4 p-4 bg-blue-50 dark:bg-blue-900/20 rounded-xl border border-blue-100 dark:border-blue-800 flex gap-3 items-start">
                    <i class="fa-solid fa-circle-info text-blue-500 mt-0.5"></i>
                    <p class="text-xs text-blue-700 dark:text-blue-300 leading-relaxed">
                        Las categorías ayudan a organizar tu menú. Asegúrate de que sean claras para tus clientes (ej: "Platos de Fondo", "Postres").
                    </p>
                </div>
            </div>

            <div class="lg:col-span-2">
                <div class="bg-white dark:bg-dark-eval-1 rounded-2xl shadow-lg border border-gray-100 dark:border-gray-700 overflow-hidden">

                    <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-700 flex justify-between items-center bg-gray-50/50 dark:bg-gray-800/50">
                        <h3 class="font-bold text-gray-700 dark:text-gray-200 flex items-center gap-2">
                            <i class="fa-solid fa-list-ul text-gray-400"></i> Listado Actual
                        </h3>
                        <span class="text-xs font-bold bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-600 px-2 py-1 rounded text-gray-500 dark:text-gray-300">
                            {{ $categorias->count() }} Registros
                        </span>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-100 dark:divide-gray-700">
                            <tbody class="divide-y divide-gray-100 dark:divide-gray-700 bg-white dark:bg-dark-eval-1">
                                @forelse($categorias as $cat)
                                    <tr class="group hover:bg-orange-50/50 dark:hover:bg-orange-900/10 transition-colors">

                                        <td class="px-6 py-4">
                                            <div class="flex items-center gap-4">
                                                <div class="w-10 h-10 rounded-full bg-gray-100 dark:bg-gray-700 flex items-center justify-center text-gray-400 group-hover:bg-orange-100 group-hover:text-orange-500 transition-colors">
                                                    <i class="fa-solid fa-layer-group text-lg"></i>
                                                </div>
                                                <div>
                                                    <div class="text-base font-bold text-gray-800 dark:text-white mb-0.5">
                                                        {{ $cat->name }}
                                                    </div>
                                                    <div class="text-xs text-gray-500 dark:text-gray-400 flex items-center gap-1">
                                                        <i class="fa-solid fa-utensils text-[10px]"></i>
                                                        {{ $cat->products->count() }} productos asociados
                                                    </div>
                                                </div>
                                            </div>
                                        </td>

                                        <td class="px-6 py-4 text-right">
                                            <div class="flex justify-end gap-2 opacity-100 sm:opacity-0 sm:group-hover:opacity-100 transition-opacity">

                                                <a href="{{ route('admin.categorias.edit', $cat->id) }}"
                                                   class="w-8 h-8 rounded-full bg-indigo-50 text-indigo-600 hover:bg-indigo-100 hover:text-indigo-700 flex items-center justify-center transition-all hover:scale-110 shadow-sm border border-indigo-200"
                                                   title="Editar Categoría">
                                                    <i class="fa-solid fa-pen-to-square"></i>
                                                </a>

                                                <form action="{{ route('admin.categorias.destroy', $cat->id) }}" method="POST" class="inline-block">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button"
                                                            onclick="confirmarBorrado(event, '{{ $cat->name }}')"
                                                            class="w-8 h-8 rounded-full bg-red-50 text-red-600 hover:bg-red-100 hover:text-red-700 flex items-center justify-center transition-all hover:scale-110 shadow-sm border border-red-200"
                                                            title="Eliminar Categoría">
                                                        <i class="fa-solid fa-trash-can"></i>
                                                    </button>
                                                </form>

                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="2" class="px-6 py-12 text-center">
                                            <div class="flex flex-col items-center justify-center text-gray-400">
                                                <i class="fa-regular fa-folder-open text-4xl mb-3 opacity-50"></i>
                                                <p class="text-sm font-medium">No hay categorías creadas aún.</p>
                                                <p class="text-xs mt-1">Utiliza el formulario de la izquierda para crear una.</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const successMessage = "{{ session('status') }}";
            const errorMessage = "{{ session('error') }}";

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

            if (errorMessage) {
                Swal.fire({
                    title: '¡Error!',
                    text: errorMessage,
                    icon: 'error',
                    confirmButtonColor: '#EF4444',
                    confirmButtonText: 'Entendido'
                });
            }
        });

        function confirmarBorrado(event, nombreCategoria) {
            event.preventDefault();
            const form = event.target.closest('form');

            Swal.fire({
                title: '¿Eliminar Categoría?',
                text: "Estás a punto de borrar '" + nombreCategoria + "'. Si tiene productos asociados, esto podría causar problemas.",
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
