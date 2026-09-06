<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <div class="p-2 bg-blue-100 dark:bg-blue-900 rounded-lg text-blue-600 dark:text-blue-300">
                <i class="fa-solid fa-user-plus text-xl"></i>
            </div>
            <h2 class="text-xl font-bold leading-tight text-gray-800 dark:text-gray-200">
                {{ __('Registrar Nuevo Repartidor') }}
            </h2>
        </div>
    </x-slot>

    <div class="p-6 max-w-xl mx-auto">

        <div class="bg-white dark:bg-dark-eval-1 rounded-2xl shadow-md border border-gray-100 dark:border-gray-700 overflow-hidden">

            <form action="{{ route('admin.repartidores.store') }}" method="POST" class="p-6 md:p-8">
                @csrf

                @if ($errors->any())
                <div class="mb-6 p-4 bg-red-50 dark:bg-red-900/20 border border-red-100 dark:border-red-800 rounded-xl flex items-start gap-3">
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
                            Nombre del Personal <span class="text-red-500">*</span>
                        </label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400 group-focus-within:text-blue-500">
                                <i class="fa-solid fa-user"></i>
                            </div>
                            <input type="text" name="nombre" placeholder="Ej: Juan Pérez" required
                                class="w-full pl-10 py-3 text-sm border-gray-200 dark:border-gray-600 rounded-xl bg-gray-50 dark:bg-dark-eval-2 text-gray-800 dark:text-gray-200 focus:ring-2 focus:ring-blue-500/50 focus:border-blue-500 transition-all shadow-sm placeholder-gray-400">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-500 dark:text-gray-400 mb-1.5 ml-1 uppercase tracking-wide">
                            Teléfono de Contacto
                        </label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400 group-focus-within:text-blue-500">
                                <i class="fa-solid fa-phone"></i>
                            </div>
                            <input type="tel" name="telefono" maxlength="9" pattern="[0-9]{9}" placeholder="999888777"
                                oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                class="w-full pl-10 py-3 text-sm border-gray-200 dark:border-gray-600 rounded-xl bg-gray-50 dark:bg-dark-eval-2 text-gray-800 dark:text-gray-200 focus:ring-2 focus:ring-blue-500/50 focus:border-blue-500 transition-all shadow-sm placeholder-gray-400">
                        </div>
                        <p class="text-[10px] text-gray-400 mt-1 ml-1">Solo números, 9 dígitos.</p>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-500 dark:text-gray-400 mb-1.5 ml-1 uppercase tracking-wide">
                            Placa del Vehículo
                        </label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400 group-focus-within:text-blue-500">
                                <i class="fa-solid fa-motorcycle"></i>
                            </div>
                            <input type="text" name="placa_vehiculo" placeholder="Ej: 1234-AB"
                                class="w-full pl-10 py-3 text-sm border-gray-200 dark:border-gray-600 rounded-xl bg-gray-50 dark:bg-dark-eval-2 text-gray-800 dark:text-gray-200 focus:ring-2 focus:ring-blue-500/50 focus:border-blue-500 transition-all shadow-sm placeholder-gray-400 uppercase font-mono">
                        </div>
                    </div>

                </div>

                <div class="flex flex-col sm:flex-row justify-end items-center gap-3 pt-8 mt-4 border-t border-gray-100 dark:border-gray-700">
                    <a href="{{ route('admin.repartidores.index') }}"
                       class="w-full sm:w-auto px-5 py-2.5 bg-white border border-gray-300 text-gray-700 rounded-xl hover:bg-gray-50 font-bold transition-colors text-center shadow-sm dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300 dark:hover:bg-gray-600">
                        Cancelar
                    </a>

                    <button type="submit"
                            class="w-full sm:w-auto px-6 py-2.5 bg-gradient-to-r from-blue-600 to-blue-500 hover:from-blue-700 hover:to-blue-600 text-white rounded-xl shadow-md hover:shadow-lg font-bold transition-all transform hover:-translate-y-0.5 flex items-center justify-center gap-2">
                        <i class="fa-solid fa-floppy-disk"></i>
                        Guardar Repartidor
                    </button>
                </div>

            </form>
        </div>
    </div>
</x-app-layout>
