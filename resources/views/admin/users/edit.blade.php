<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <div class="p-2 bg-orange-100 dark:bg-orange-900 rounded-lg text-orange-600 dark:text-orange-300">
                <i class="fa-solid fa-user-pen text-xl"></i>
            </div>
            <h2 class="text-xl font-bold leading-tight text-gray-800 dark:text-gray-200">
                {{ __('Editar Datos del Personal') }}
            </h2>
        </div>
    </x-slot>

    <div class="p-6 max-w-xl mx-auto">

        <div class="bg-white dark:bg-dark-eval-1 rounded-2xl shadow-md border border-gray-100 dark:border-gray-700 overflow-hidden">

            <form action="{{ route('admin.users.update', $user->id) }}" method="POST" class="p-6 md:p-8">
                @csrf
                @method('PUT')

                @if ($errors->any())
                <div class="mb-8 p-4 bg-red-50 dark:bg-red-900/20 border border-red-100 dark:border-red-800 rounded-xl flex items-start gap-3">
                    <i class="fa-solid fa-circle-exclamation text-red-500 mt-0.5"></i>
                    <div>
                        <h4 class="font-bold text-red-700 dark:text-red-400 text-sm">Hay errores en el formulario:</h4>
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
                            Nombre Completo
                        </label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400 group-focus-within:text-orange-500">
                                <i class="fa-solid fa-user"></i>
                            </div>
                            <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                                class="w-full pl-10 py-3 text-sm border-gray-200 dark:border-gray-600 rounded-xl bg-gray-50 dark:bg-dark-eval-2 text-gray-800 dark:text-gray-200 focus:ring-2 focus:ring-orange-500/50 focus:border-orange-500 transition-all shadow-sm placeholder-gray-400">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-500 dark:text-gray-400 mb-1.5 ml-1 uppercase tracking-wide">
                            Correo Electrónico
                        </label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400 group-focus-within:text-orange-500">
                                <i class="fa-solid fa-envelope"></i>
                            </div>
                            <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                                class="w-full pl-10 py-3 text-sm border-gray-200 dark:border-gray-600 rounded-xl bg-gray-50 dark:bg-dark-eval-2 text-gray-800 dark:text-gray-200 focus:ring-2 focus:ring-orange-500/50 focus:border-orange-500 transition-all shadow-sm placeholder-gray-400">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-500 dark:text-gray-400 mb-1.5 ml-1 uppercase tracking-wide">
                            Rol Asignado
                        </label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400 group-focus-within:text-orange-500">
                                <i class="fa-solid fa-id-card-clip"></i>
                            </div>
                            <select name="role" class="w-full pl-10 py-3 text-sm border-gray-200 dark:border-gray-600 rounded-xl bg-gray-50 dark:bg-dark-eval-2 text-gray-800 dark:text-gray-200 focus:ring-2 focus:ring-orange-500/50 focus:border-orange-500 transition-all shadow-sm appearance-none cursor-pointer">
                                <option value="mozo" {{ $user->role == 'mozo' ? 'selected' : '' }}>Mozo (Atención)</option>
                                <option value="cocina" {{ $user->role == 'cocina' ? 'selected' : '' }}>Cocina (Pantalla KDS)</option>
                                <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Administrador</option>
                            </select>
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none text-gray-400">
                                <i class="fa-solid fa-chevron-down text-xs"></i>
                            </div>
                        </div>
                    </div>

                    <div class="mt-8 p-5 bg-orange-50/50 dark:bg-orange-900/10 border border-orange-100 dark:border-orange-800/30 rounded-xl">
                        <div class="flex items-center gap-2 mb-4 border-b border-orange-200 dark:border-orange-800 pb-2">
                            <i class="fa-solid fa-lock text-orange-500"></i>
                            <h3 class="text-xs font-bold text-orange-700 dark:text-orange-300 uppercase tracking-widest">
                                Seguridad (Opcional)
                            </h3>
                        </div>

                        <p class="text-[10px] text-gray-500 dark:text-gray-400 mb-4 flex items-start gap-1">
                            <i class="fa-solid fa-circle-info mt-0.5 text-orange-400"></i>
                            Solo llena estos campos si deseas cambiar la contraseña actual.
                        </p>

                        <div class="space-y-4">
                            <div class="relative group">
                                <input type="password" name="password" autocomplete="new-password" placeholder="Nueva Contraseña"
                                    class="w-full px-4 py-2.5 text-sm border-gray-200 dark:border-gray-600 rounded-lg bg-white dark:bg-dark-eval-2 text-gray-800 dark:text-gray-200 focus:ring-2 focus:ring-orange-500/50 focus:border-orange-500 transition-all shadow-sm placeholder-gray-400">
                            </div>

                            <div class="relative group">
                                <input type="password" name="password_confirmation" placeholder="Confirmar Nueva Contraseña"
                                    class="w-full px-4 py-2.5 text-sm border-gray-200 dark:border-gray-600 rounded-lg bg-white dark:bg-dark-eval-2 text-gray-800 dark:text-gray-200 focus:ring-2 focus:ring-orange-500/50 focus:border-orange-500 transition-all shadow-sm placeholder-gray-400">
                            </div>
                        </div>
                    </div>

                </div>

                <div class="flex flex-col sm:flex-row justify-end items-center gap-3 pt-8 mt-4 border-t border-gray-100 dark:border-gray-700">
                    <a href="{{ route('admin.users.index') }}"
                       class="w-full sm:w-auto px-5 py-2.5 bg-white border border-gray-300 text-gray-700 rounded-xl hover:bg-gray-50 font-bold transition-colors text-center shadow-sm dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300 dark:hover:bg-gray-600">
                        Cancelar
                    </a>

                    <button type="submit"
                            class="w-full sm:w-auto px-6 py-2.5 bg-gradient-to-r from-orange-600 to-orange-500 hover:from-orange-700 hover:to-orange-600 text-white rounded-xl shadow-md hover:shadow-lg font-bold transition-all transform hover:-translate-y-0.5 flex items-center justify-center gap-2">
                        <i class="fa-solid fa-rotate"></i>
                        Actualizar Usuario
                    </button>
                </div>

            </form>
        </div>
    </div>
</x-app-layout>
