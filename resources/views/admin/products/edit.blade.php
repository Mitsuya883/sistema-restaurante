<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <div class="p-2 bg-orange-100 dark:bg-orange-900 rounded-lg text-orange-600 dark:text-orange-300">
                <i class="fa-solid fa-pen-to-square text-xl"></i>
            </div>
            <h2 class="text-xl font-bold leading-tight text-gray-800 dark:text-gray-200">
                {{ __('Editar Plato') }} <span class="text-gray-400 font-medium text-sm">#{{ $product->id }}</span>
            </h2>
        </div>
    </x-slot>

    <div class="p-6 max-w-3xl mx-auto">

        <div class="bg-white dark:bg-dark-eval-1 rounded-2xl shadow-md border border-gray-100 dark:border-gray-700 overflow-hidden">

            <form action="{{ route('admin.products.update', $product) }}" method="POST" class="p-6 md:p-8">
                @csrf
                @method('PUT')

                @if ($errors->any())
                <div class="mb-8 p-4 bg-red-50 dark:bg-red-900/20 border border-red-100 dark:border-red-800 rounded-xl flex items-start gap-3">
                    <i class="fa-solid fa-circle-exclamation text-red-500 mt-0.5"></i>
                    <div>
                        <h4 class="font-bold text-red-700 dark:text-red-400 text-sm">Por favor corrige los errores:</h4>
                        <ul class="list-disc list-inside text-xs text-red-600 dark:text-red-300 mt-1">
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                @endif

                <div class="space-y-6">

                    <div>
                        <label class="block text-xs font-bold text-gray-500 dark:text-gray-400 mb-1.5 ml-1 uppercase tracking-wide">
                            Nombre del Plato
                        </label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400 group-focus-within:text-orange-500">
                                <i class="fa-solid fa-font"></i>
                            </div>
                            <input type="text" name="name" value="{{ old('name', $product->name) }}" required
                                class="w-full pl-10 py-3 text-sm border-gray-200 dark:border-gray-600 rounded-xl bg-gray-50 dark:bg-dark-eval-2 text-gray-800 dark:text-gray-200 focus:ring-2 focus:ring-orange-500/50 focus:border-orange-500 transition-all shadow-sm placeholder-gray-400">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                        <div>
                            <label class="block text-xs font-bold text-gray-500 dark:text-gray-400 mb-1.5 ml-1 uppercase tracking-wide">
                                Categoría
                            </label>
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400 group-focus-within:text-orange-500">
                                    <i class="fa-solid fa-layer-group"></i>
                                </div>
                                <select name="category_id" class="w-full pl-10 py-3 text-sm border-gray-200 dark:border-gray-600 rounded-xl bg-gray-50 dark:bg-dark-eval-2 text-gray-800 dark:text-gray-200 focus:ring-2 focus:ring-orange-500/50 focus:border-orange-500 transition-all shadow-sm appearance-none cursor-pointer">
                                    @foreach($categories as $cat)
                                        <option value="{{ $cat->id }}" {{ $product->category_id == $cat->id ? 'selected' : '' }}>
                                            {{ $cat->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none text-gray-400">
                                    <i class="fa-solid fa-chevron-down text-xs"></i>
                                </div>
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-500 dark:text-gray-400 mb-1.5 ml-1 uppercase tracking-wide">
                                Precio Unitario
                            </label>
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400 group-focus-within:text-orange-500">
                                    <i class="fa-solid fa-money-bill-wave"></i>
                                </div>
                                <input type="number" step="0.10" name="price" value="{{ old('price', $product->price) }}" required
                                    class="w-full pl-10 py-3 text-sm border-gray-200 dark:border-gray-600 rounded-xl bg-gray-50 dark:bg-dark-eval-2 text-gray-800 dark:text-gray-200 focus:ring-2 focus:ring-orange-500/50 focus:border-orange-500 transition-all shadow-sm placeholder-gray-400">
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none text-gray-400 font-bold text-xs">
                                    S/
                                </div>
                            </div>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-500 dark:text-gray-400 mb-1.5 ml-1 uppercase tracking-wide">
                            Descripción
                        </label>
                        <div class="relative group">
                            <div class="absolute top-3 left-3 flex items-center pointer-events-none text-gray-400 group-focus-within:text-orange-500">
                                <i class="fa-solid fa-align-left"></i>
                            </div>
                            <textarea name="description" rows="4"
                                class="w-full pl-10 py-3 text-sm border-gray-200 dark:border-gray-600 rounded-xl bg-gray-50 dark:bg-dark-eval-2 text-gray-800 dark:text-gray-200 focus:ring-2 focus:ring-orange-500/50 focus:border-orange-500 transition-all shadow-sm resize-none">{{ old('description', $product->description) }}</textarea>
                        </div>
                    </div>

                </div>

                <div class="flex flex-col sm:flex-row justify-end items-center gap-3 pt-8 mt-4 border-t border-gray-100 dark:border-gray-700">
                    <a href="{{ route('admin.products.index') }}"
                        class="w-full sm:w-auto px-5 py-2.5 bg-white border border-gray-300 text-gray-700 rounded-xl hover:bg-gray-50 font-bold transition-colors text-center shadow-sm dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300 dark:hover:bg-gray-600">
                        Cancelar
                    </a>

                    <button type="submit"
                            class="w-full sm:w-auto px-6 py-2.5 bg-gradient-to-r from-orange-600 to-orange-500 hover:from-orange-700 hover:to-orange-600 text-white rounded-xl shadow-md hover:shadow-lg font-bold transition-all transform hover:-translate-y-0.5 flex items-center justify-center gap-2">
                        <i class="fa-solid fa-rotate"></i>
                        Actualizar Plato
                    </button>
                </div>

            </form>
        </div>
    </div>
</x-app-layout>
