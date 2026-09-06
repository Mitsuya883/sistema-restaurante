<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
            <div class="flex items-center gap-3">
                <div class="p-2 bg-blue-100 dark:bg-blue-900 rounded-lg text-blue-600 dark:text-blue-300">
                    <i class="fa-solid fa-users-gear text-xl"></i>
                </div>
                <h2 class="text-xl font-bold leading-tight text-gray-800 dark:text-gray-200">
                    {{ __('Gestión de Personal') }}
                </h2>
            </div>

            <a href="{{ route('admin.users.create') }}"
                class="bg-gradient-to-r from-blue-600 to-blue-500 hover:from-blue-700 hover:to-blue-600 text-white px-5 py-2.5 rounded-xl font-bold shadow-lg shadow-blue-500/30 transition-all transform hover:-translate-y-0.5 flex items-center gap-2">
                <i class="fa-solid fa-user-plus"></i> Nuevo Personal
            </a>
        </div>
    </x-slot>

    <div class="p-6 max-w-7xl mx-auto">
        <div class="bg-white dark:bg-dark-eval-1 overflow-hidden shadow-xl rounded-2xl border border-gray-100 dark:border-gray-700">

            @if($users->isEmpty())
            <div class="flex flex-col items-center justify-center p-12 text-center">
                <div class="w-16 h-16 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center mb-4">
                    <i class="fa-solid fa-users-slash text-3xl text-gray-400"></i>
                </div>
                <h3 class="text-lg font-bold text-gray-600 dark:text-gray-300">No hay personal registrado</h3>
                <p class="text-sm text-gray-400 mt-1">Registra mozos, cocineros o administradores.</p>
            </div>
            @else
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-800/50">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-black text-gray-400 uppercase tracking-wider">Nombre / Email</th>
                            <th class="px-6 py-4 text-left text-xs font-black text-gray-400 uppercase tracking-wider">Rol</th>
                            <th class="px-6 py-4 text-center text-xs font-black text-gray-400 uppercase tracking-wider">Estado</th>
                            <th class="px-6 py-4 text-right text-xs font-black text-gray-400 uppercase tracking-wider">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-700 bg-white dark:bg-dark-eval-1">
                        @foreach($users as $user)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/30 transition-colors group">

                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 flex items-center justify-center text-xs font-bold uppercase">
                                        {{ substr($user->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <div class="text-sm font-bold text-gray-900 dark:text-white">
                                            {{ $user->name }}
                                        </div>
                                        <div class="text-xs text-gray-400">
                                            {{ $user->email }}
                                        </div>
                                    </div>
                                </div>
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($user->role === 'admin')
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full bg-purple-100 text-purple-700 border border-purple-200">
                                    Administrador
                                </span>
                                @elseif($user->role === 'cocina')
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full bg-orange-100 text-orange-700 border border-orange-200">
                                    Cocina
                                </span>
                                @else
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full bg-blue-100 text-blue-700 border border-blue-200">
                                    Mozo
                                </span>
                                @endif
                            </td>

                            <td class="px-6 py-4 text-center whitespace-nowrap">
                                @if($user->is_active)
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400 border border-green-200 dark:border-green-800">
                                    Activo
                                </span>
                                @else
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400 border border-red-200 dark:border-red-800">
                                    Inactivo
                                </span>
                                @endif
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex items-center justify-end gap-2 opacity-80 group-hover:opacity-100 transition-opacity">

                                    <a href="{{ route('admin.users.edit', $user->id) }}" class="w-8 h-8 rounded-full bg-indigo-50 text-indigo-600 hover:bg-indigo-100 hover:text-indigo-700 flex items-center justify-center transition-all hover:scale-110 shadow-sm border border-indigo-200" title="Editar Datos">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>

                                    <form action="{{ route('admin.users.toggle', $user->id) }}" method="POST" class="inline-block">
                                        @csrf
                                        @method('PUT')

                                        @if($user->is_active)
                                        <button type="button" onclick="confirmarCambioEstado(event, '{{ $user->name }}', 'desactivar')" class="w-8 h-8 rounded-full bg-red-50 text-red-600 hover:bg-red-100 hover:text-red-700 flex items-center justify-center transition-all hover:scale-110 shadow-sm border border-red-200" title="Dar de baja">
                                            <i class="fa-solid fa-user-slash"></i>
                                        </button>
                                        @else
                                        <button type="button" onclick="confirmarCambioEstado(event, '{{ $user->name }}', 'activar')" class="w-8 h-8 rounded-full bg-green-50 text-green-600 hover:bg-green-100 hover:text-green-700 flex items-center justify-center transition-all hover:scale-110 shadow-sm border border-green-200" title="Reactivar Usuario">
                                            <i class="fa-solid fa-user-check"></i>
                                        </button>
                                        @endif
                                    </form>

                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @endif
        </div>
    </div>
</x-app-layout>

<input type="hidden" id="session-status" value="{{ session('status') }}">
<input type="hidden" id="session-error" value="{{ session('error') }}">

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const mensajeExito = document.getElementById('session-status').value;

        if (mensajeExito) {
            if (mensajeExito.includes('contraseña')) {
                const partes = mensajeExito.split(': ');
                const password = partes[1] || 'Revisa tu correo';

                Swal.fire({
                    title: '¡Usuario Registrado!',
                    html: `
                        <p class="mb-4">Se ha enviado un correo con los accesos a <b>${password ? 'el usuario' : ''}</b>.</p>

                        <div class="bg-orange-50 p-4 rounded-lg border border-orange-200 text-center">
                            <p class="text-xs text-orange-800 font-bold uppercase mb-1">Contraseña Generada:</p>
                            <div class="text-2xl text-gray-800 font-mono tracking-wider select-all bg-white py-2 rounded border border-orange-100 shadow-sm">
                                ${password}
                            </div>
                        </div>
                        <p class="text-xs text-gray-400 mt-4">Copia esta clave por seguridad, aunque ya fue enviada por correo.</p>
                    `,
                    icon: 'success',
                    confirmButtonColor: '#ea580c',
                    confirmButtonText: 'Entendido'
                });
            } else {
                Swal.fire({
                    title: '¡Éxito!',
                    text: mensajeExito,
                    icon: 'success',
                    timer: 2000,
                    showConfirmButton: false
                });
            }
        }
    });
</script>
