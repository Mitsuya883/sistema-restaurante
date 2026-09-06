<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <div class="p-2 bg-orange-100 dark:bg-orange-900 rounded-lg text-orange-600 dark:text-orange-300">
                <i class="fa-solid fa-user-plus text-xl"></i>
            </div>
            <h2 class="text-xl font-bold leading-tight text-gray-800 dark:text-gray-200">
                {{ __('Registrar Nuevo Personal') }}
            </h2>
        </div>
    </x-slot>

    <div class="p-6 max-w-xl mx-auto">

        <div class="bg-white dark:bg-dark-eval-1 rounded-2xl shadow-md border border-gray-100 dark:border-gray-700 overflow-hidden">

            <form action="{{ route('admin.users.store') }}" method="POST" class="p-6 md:p-8">
                @csrf

                <div class="mb-8 p-4 bg-orange-50 dark:bg-orange-900/20 border border-orange-100 dark:border-orange-800 rounded-xl flex items-start gap-3">
                    <div class="p-1 bg-orange-100 dark:bg-orange-800 rounded-full text-orange-600 dark:text-orange-300 shrink-0">
                        <i class="fa-solid fa-key text-xs"></i>
                    </div>
                    <div>
                        <h4 class="font-bold text-orange-800 dark:text-orange-300 text-sm">Generación de Credenciales</h4>
                        <p class="text-xs text-orange-600 dark:text-orange-400 mt-0.5 leading-relaxed">
                            El sistema generará una <strong>contraseña segura automática</strong>. Asegúrate de copiarla o enviarla al usuario al finalizar el registro.
                        </p>
                    </div>
                </div>

                <div class="space-y-6">

                    <div>
                        <label class="block text-xs font-bold text-gray-500 dark:text-gray-400 mb-1.5 ml-1 uppercase tracking-wide">
                            Nombre Completo <span class="text-red-500">*</span>
                        </label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400 group-focus-within:text-orange-500">
                                <i class="fa-solid fa-user"></i>
                            </div>
                            <input type="text" name="name" value="{{ old('name') }}" required autofocus placeholder="Ej: Juan Pérez"
                                class="w-full pl-10 py-3 text-sm border-gray-200 dark:border-gray-600 rounded-xl bg-gray-50 dark:bg-dark-eval-2 text-gray-800 dark:text-gray-200 focus:ring-2 focus:ring-orange-500/50 focus:border-orange-500 transition-all shadow-sm placeholder-gray-400">
                        </div>
                        @error('name') <span class="text-red-500 text-xs mt-1 ml-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-500 dark:text-gray-400 mb-1.5 ml-1 uppercase tracking-wide">
                            Correo Electrónico <span class="text-red-500">*</span>
                        </label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400 group-focus-within:text-orange-500">
                                <i class="fa-solid fa-envelope"></i>
                            </div>
                            <input type="email" name="email" value="{{ old('email') }}" required placeholder="juan@restaurante.com"
                                class="w-full pl-10 py-3 text-sm border-gray-200 dark:border-gray-600 rounded-xl bg-gray-50 dark:bg-dark-eval-2 text-gray-800 dark:text-gray-200 focus:ring-2 focus:ring-orange-500/50 focus:border-orange-500 transition-all shadow-sm placeholder-gray-400">
                        </div>
                        @error('email') <span class="text-red-500 text-xs mt-1 ml-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-500 dark:text-gray-400 mb-1.5 ml-1 uppercase tracking-wide">
                            Rol Asignado <span class="text-red-500">*</span>
                        </label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400 group-focus-within:text-orange-500">
                                <i class="fa-solid fa-id-badge"></i>
                            </div>
                            <select name="role" class="w-full pl-10 py-3 text-sm border-gray-200 dark:border-gray-600 rounded-xl bg-gray-50 dark:bg-dark-eval-2 text-gray-800 dark:text-gray-200 focus:ring-2 focus:ring-orange-500/50 focus:border-orange-500 transition-all shadow-sm appearance-none cursor-pointer">
                                <option value="mozo">Mozo (Atención)</option>
                                <option value="cocina">Cocina (Pantalla KDS)</option>
                                <option value="admin">Administrador</option>
                            </select>
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none text-gray-400">
                                <i class="fa-solid fa-chevron-down text-xs"></i>
                            </div>
                        </div>
                        @error('role') <span class="text-red-500 text-xs mt-1 ml-1 block">{{ $message }}</span> @enderror
                    </div>

                </div>

                <div class="flex flex-col sm:flex-row justify-end items-center gap-3 pt-8 mt-4 border-t border-gray-100 dark:border-gray-700">
                    <a href="{{ route('admin.users.index') }}"
                       class="w-full sm:w-auto px-5 py-2.5 bg-white border border-gray-300 text-gray-700 rounded-xl hover:bg-gray-50 font-bold transition-colors text-center shadow-sm dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300 dark:hover:bg-gray-600">
                        Cancelar
                    </a>

                    <button type="submit"
                            class="w-full sm:w-auto px-6 py-2.5 bg-gradient-to-r from-orange-600 to-orange-500 hover:from-orange-700 hover:to-orange-600 text-white rounded-xl shadow-md hover:shadow-lg font-bold transition-all transform hover:-translate-y-0.5 flex items-center justify-center gap-2">
                        <i class="fa-solid fa-floppy-disk"></i>
                        Guardar y Generar Clave
                    </button>
                </div>

            </form>
        </div>
    </div>
</x-app-layout>
