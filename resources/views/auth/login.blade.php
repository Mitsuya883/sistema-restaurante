<x-guest-layout>
    <div class="flex flex-col items-center justify-center min-h-screen bg-gray-100 dark:bg-gray-900 p-4">

        <div class="mb-8 text-center">
            <a href="/">
                <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-24 w-auto mx-auto ">
            </a>
            <h2 class="mt-4 text-2xl font-black text-gray-800 dark:text-gray-200 tracking-tight">
                ¡Bienvenido de nuevo!
            </h2>
            <p class="text-sm text-gray-500 dark:text-gray-400">Ingresa tus credenciales para acceder</p>
        </div>

        <div class="w-full max-w-md bg-white dark:bg-dark-eval-1 rounded-2xl shadow-xl border border-gray-100 dark:border-gray-700 overflow-hidden">

            <div class="p-8">
                <x-auth-session-status class="mb-4" :status="session('status')" />

                @if ($errors->any())
                    <div class="mb-6 p-4 bg-red-50 dark:bg-red-900/20 border-l-4 border-red-500 rounded-r-lg">
                        <div class="flex items-start gap-3">
                            <i class="fa-solid fa-circle-exclamation text-red-500 mt-0.5"></i>
                            <div>
                                <h4 class="font-bold text-red-700 dark:text-red-400 text-sm">Error de acceso</h4>
                                <ul class="list-disc list-inside text-xs text-red-600 dark:text-red-300 mt-1">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}" class="space-y-6">
                    @csrf

                    <div>
                        <label for="email" class="block text-xs font-bold text-gray-500 dark:text-gray-400 mb-1.5 uppercase tracking-wide ml-1">
                            Correo Electrónico
                        </label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400 group-focus-within:text-orange-500 transition-colors">
                                <x-heroicon-o-mail class="w-5 h-5" />
                            </div>
                            <input id="email" type="email" name="email" :value="old('email')" required autofocus placeholder="tucorreo@ejemplo.com"
                                class="w-full pl-10 py-3 text-sm border-gray-200 dark:border-gray-600 rounded-xl bg-gray-50 dark:bg-dark-eval-2 text-gray-800 dark:text-gray-200 focus:ring-2 focus:ring-orange-500/50 focus:border-orange-500 transition-all shadow-sm placeholder-gray-400">
                        </div>
                    </div>

                    <div>
                        <label for="password" class="block text-xs font-bold text-gray-500 dark:text-gray-400 mb-1.5 uppercase tracking-wide ml-1">
                            Contraseña
                        </label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400 group-focus-within:text-orange-500 transition-colors">
                                <x-heroicon-o-lock-closed class="w-5 h-5" />
                            </div>
                            <input id="password" type="password" name="password" required autocomplete="current-password" placeholder="••••••••"
                                class="w-full pl-10 py-3 text-sm border-gray-200 dark:border-gray-600 rounded-xl bg-gray-50 dark:bg-dark-eval-2 text-gray-800 dark:text-gray-200 focus:ring-2 focus:ring-orange-500/50 focus:border-orange-500 transition-all shadow-sm placeholder-gray-400">
                        </div>
                    </div>

                    <button type="submit" class="w-full py-3 bg-gradient-to-r from-orange-600 to-orange-500 hover:from-orange-700 hover:to-orange-600 text-white rounded-xl shadow-lg shadow-orange-500/30 font-bold transition-all transform hover:-translate-y-0.5 active:scale-95 flex items-center justify-center gap-2">
                        <x-heroicon-o-login class="w-5 h-5" />
                        <span>Iniciar Sesión</span>
                    </button>

                </form>
            </div>

            <div class="px-8 py-4 bg-gray-50 dark:bg-gray-800 border-t border-gray-100 dark:border-gray-700 text-center">
                <p class="text-xs text-gray-400">
                    &copy; {{ date('Y') }} Sistema de Restaurante
                </p>
            </div>
        </div>
    </div>
</x-guest-layout>
