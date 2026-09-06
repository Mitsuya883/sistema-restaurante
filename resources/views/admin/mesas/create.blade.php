<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <div class="p-2 bg-blue-100 dark:bg-blue-900 rounded-lg text-blue-600 dark:text-blue-300">
                <i class="fa-solid fa-square-plus text-xl"></i>
            </div>
            <h2 class="text-xl font-bold leading-tight text-gray-800 dark:text-gray-200">
                {{ __('Registrar Nueva Mesa') }}
            </h2>
        </div>
    </x-slot>

    <div class="p-6 max-w-xl mx-auto">

        <div class="bg-white dark:bg-dark-eval-1 rounded-2xl shadow-md border border-gray-100 dark:border-gray-700 overflow-hidden">

            <form action="{{ route('admin.mesas.store') }}" method="POST" class="p-6 md:p-8">
                @csrf

                <div class="mb-8 p-4 bg-blue-50 dark:bg-blue-900/20 border border-blue-100 dark:border-blue-800 rounded-xl flex items-start gap-3">
                    <div class="p-1 bg-blue-100 dark:bg-blue-800 rounded-full text-blue-600 dark:text-blue-300">
                        <i class="fa-solid fa-wand-magic-sparkles text-sm"></i>
                    </div>
                    <div>
                        <h4 class="font-bold text-blue-800 dark:text-blue-300 text-sm">Autogeneración de Código</h4>
                        <p class="text-xs text-blue-600 dark:text-blue-400 mt-0.5">
                            El sistema asignará automáticamente un código único (ej: <strong>ME-05</strong>) al guardar.
                        </p>
                    </div>
                </div>

                <div class="space-y-6">

                    <div>
                        <label class="block text-xs font-bold text-gray-500 dark:text-gray-400 mb-1.5 ml-1 uppercase tracking-wide">
                            Identificador de Mesa
                        </label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400 group-focus-within:text-blue-500">
                                <i class="fa-solid fa-tag"></i>
                            </div>
                            <input type="text" name="name" placeholder="Ej: Mesa 5, Terraza 1, Barra..." required
                                class="w-full pl-10 py-3 text-sm border-gray-200 dark:border-gray-600 rounded-xl bg-gray-50 dark:bg-dark-eval-2 text-gray-800 dark:text-gray-200 focus:ring-2 focus:ring-blue-500/50 focus:border-blue-500 transition-all shadow-sm placeholder-gray-400">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-500 dark:text-gray-400 mb-1.5 ml-1 uppercase tracking-wide">
                            Capacidad Máxima
                        </label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400 group-focus-within:text-blue-500">
                                <i class="fa-solid fa-users"></i>
                            </div>
                            <input type="number" name="capacity" value="4" min="1" required
                                class="w-full pl-10 py-3 text-sm border-gray-200 dark:border-gray-600 rounded-xl bg-gray-50 dark:bg-dark-eval-2 text-gray-800 dark:text-gray-200 focus:ring-2 focus:ring-blue-500/50 focus:border-blue-500 transition-all shadow-sm">

                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none text-xs font-bold text-gray-400">
                                personas
                            </div>
                        </div>
                    </div>

                </div>

                <div class="flex flex-col sm:flex-row justify-end items-center gap-3 pt-8 mt-4 border-t border-gray-100 dark:border-gray-700">
                    <a href="{{ route('admin.mesas.index') }}"
                       class="w-full sm:w-auto px-5 py-2.5 bg-white border border-gray-300 text-gray-700 rounded-xl hover:bg-gray-50 font-bold transition-colors text-center shadow-sm dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300 dark:hover:bg-gray-600">
                        Cancelar
                    </a>

                    <button type="submit"
                            class="w-full sm:w-auto px-6 py-2.5 bg-gradient-to-r from-blue-600 to-blue-500 hover:from-blue-700 hover:to-blue-600 text-white rounded-xl shadow-md hover:shadow-lg font-bold transition-all transform hover:-translate-y-0.5 flex items-center justify-center gap-2">
                        <i class="fa-solid fa-floppy-disk"></i>
                        Guardar Mesa
                    </button>
                </div>

            </form>
        </div>
    </div>
</x-app-layout>
