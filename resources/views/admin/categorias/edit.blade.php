<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <div class="p-2 bg-orange-100 dark:bg-orange-900 rounded-lg text-orange-600 dark:text-orange-300">
                <i class="fa-solid fa-pen-to-square text-xl"></i>
            </div>
            <h2 class="text-xl font-bold leading-tight text-gray-800 dark:text-gray-200">
                {{ __('Editar Categoría') }}
            </h2>
        </div>
    </x-slot>

    <div class="p-6 max-w-lg mx-auto">

        <div class="bg-white dark:bg-dark-eval-1 rounded-2xl shadow-md border border-gray-100 dark:border-gray-700 overflow-hidden">

            <div class="p-6 md:p-8">

                <div class="mb-6 flex flex-col items-center text-center">
                    <span class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">Editando Registro</span>
                    <h3 class="text-2xl font-black text-gray-800 dark:text-white">
                        {{ $categoria->name }}
                    </h3>
                    <div class="h-1 w-16 bg-orange-500 rounded-full mt-3"></div>
                </div>

                <form action="{{ route('admin.categorias.update', $categoria->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-8">
                        <label class="block text-xs font-bold text-gray-500 dark:text-gray-400 mb-1.5 ml-1 uppercase tracking-wide">
                            Nombre de la Categoría
                        </label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400 group-focus-within:text-orange-500">
                                <i class="fa-solid fa-tag"></i>
                            </div>
                            <input type="text" name="name" value="{{ old('name', $categoria->name) }}" required
                                class="w-full pl-10 py-3 text-sm border-gray-200 dark:border-gray-600 rounded-xl bg-gray-50 dark:bg-dark-eval-2 text-gray-800 dark:text-gray-200 focus:ring-2 focus:ring-orange-500/50 focus:border-orange-500 transition-all shadow-sm placeholder-gray-400">
                        </div>
                        @error('name')
                            <p class="mt-1 text-xs text-red-500 flex items-center gap-1">
                                <i class="fa-solid fa-circle-exclamation"></i> {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <div class="flex flex-col sm:flex-row gap-3 pt-4 border-t border-gray-100 dark:border-gray-700">
                        <a href="{{ route('admin.categorias.index') }}"
                           class="w-full sm:w-1/2 px-5 py-2.5 bg-white border border-gray-300 text-gray-700 rounded-xl hover:bg-gray-50 font-bold transition-colors text-center shadow-sm dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300 dark:hover:bg-gray-600">
                            Cancelar
                        </a>

                        <button type="submit"
                                class="w-full sm:w-1/2 px-6 py-2.5 bg-gradient-to-r from-orange-600 to-orange-500 hover:from-orange-700 hover:to-orange-600 text-white rounded-xl shadow-md hover:shadow-lg font-bold transition-all transform hover:-translate-y-0.5 flex items-center justify-center gap-2">
                            <i class="fa-solid fa-rotate"></i>
                            Actualizar
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</x-app-layout>
