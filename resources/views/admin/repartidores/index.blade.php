<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
            <div class="flex items-center gap-3">
                <div class="p-2 bg-blue-100 dark:bg-blue-900 rounded-lg text-blue-600 dark:text-blue-300">
                    <i class="fa-solid fa-motorcycle text-xl"></i>
                </div>
                <h2 class="text-xl font-bold leading-tight text-gray-800 dark:text-gray-200">
                    {{ __('Gestión de Repartidores') }}
                </h2>
            </div>

            <a href="{{ route('admin.repartidores.create') }}" class="bg-gradient-to-r from-blue-600 to-blue-500 hover:from-blue-700 hover:to-blue-600 text-white px-5 py-2.5 rounded-xl font-bold shadow-lg shadow-blue-500/30 transition-all transform hover:-translate-y-0.5 flex items-center gap-2">
                <i class="fa-solid fa-user-plus"></i> Nuevo Repartidor
            </a>
        </div>
    </x-slot>

    <div class="p-6 max-w-7xl mx-auto">

        <div class="bg-white dark:bg-dark-eval-1 overflow-hidden shadow-xl rounded-2xl border border-gray-100 dark:border-gray-700">

            @if($repartidores->isEmpty())
                <div class="flex flex-col items-center justify-center p-12 text-center">
                    <div class="w-16 h-16 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center mb-4">
                        <i class="fa-solid fa-helmet-safety text-3xl text-gray-400"></i>
                    </div>
                    <h3 class="text-lg font-bold text-gray-600 dark:text-gray-300">No hay repartidores registrados</h3>
                    <p class="text-sm text-gray-400 mt-1">Registra a tu equipo de delivery para comenzar.</p>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-800/50">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-black text-gray-400 uppercase tracking-wider">Nombre</th>
                                <th class="px-6 py-4 text-left text-xs font-black text-gray-400 uppercase tracking-wider">Contacto</th>
                                <th class="px-6 py-4 text-left text-xs font-black text-gray-400 uppercase tracking-wider">Vehículo / Placa</th>
                                <th class="px-6 py-4 text-center text-xs font-black text-gray-400 uppercase tracking-wider">Estado</th>
                                <th class="px-6 py-4 text-right text-xs font-black text-gray-400 uppercase tracking-wider">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-700 bg-white dark:bg-dark-eval-1">
                            @foreach($repartidores as $rep)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/30 transition-colors group">

                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-full bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 flex items-center justify-center text-xs font-bold">
                                            {{ substr($rep->nombre, 0, 1) }}
                                        </div>
                                        <div class="text-sm font-bold text-gray-900 dark:text-white">
                                            {{ $rep->nombre }}
                                        </div>
                                    </div>
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($rep->telefono)
                                        <a href="tel:{{ $rep->telefono }}" class="flex items-center gap-2 text-sm text-gray-600 dark:text-gray-300 hover:text-blue-500 transition-colors">
                                            <i class="fa-solid fa-phone text-xs text-gray-400"></i>
                                            {{ $rep->telefono }}
                                        </a>
                                    @else
                                        <span class="text-xs text-gray-400 italic">No registrado</span>
                                    @endif
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center gap-2">
                                        <span class="font-mono text-xs font-bold bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 px-2 py-1 rounded border border-gray-200 dark:border-gray-600 uppercase">
                                            {{ $rep->placa_vehiculo ?? 'S/P' }}
                                        </span>
                                    </div>
                                </td>

                                <td class="px-6 py-4 text-center whitespace-nowrap">
                                    @if($rep->activo)
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

                                        <a href="{{ route('admin.repartidores.edit', $rep->id) }}" class="w-8 h-8 rounded-full bg-indigo-50 text-indigo-600 hover:bg-indigo-100 hover:text-indigo-700 flex items-center justify-center transition-all hover:scale-110 shadow-sm border border-indigo-200" title="Editar Datos">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </a>

                                        <form action="{{ route('admin.repartidores.destroy', $rep->id) }}" method="POST" class="inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" onclick="confirmarEliminacion(event, '{{ $rep->nombre }}')" class="w-8 h-8 rounded-full bg-red-50 text-red-600 hover:bg-red-100 hover:text-red-700 flex items-center justify-center transition-all hover:scale-110 shadow-sm border border-red-200" title="Eliminar Repartidor">
                                                <i class="fa-solid fa-trash-can"></i>
                                            </button>
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

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const mensajeExito = "{{ session('status') }}";
        const mensajeError = "{{ session('error') }}";

        if (mensajeExito) {
            Swal.fire({
                title: '¡Operación Exitosa!',
                text: mensajeExito,
                icon: 'success',
                confirmButtonColor: '#2563EB',
                timer: 2000,
                showConfirmButton: false
            });
        }

        if (mensajeError) {
            Swal.fire({
                title: '¡Ups!',
                text: mensajeError,
                icon: 'error',
                confirmButtonColor: '#EF4444',
                confirmButtonText: 'Entendido'
            });
        }
    });

    function confirmarEliminacion(event, nombre) {
        event.preventDefault();
        const formulario = event.target.closest('form');

        Swal.fire({
            title: '¿Dar de baja a ' + nombre + '?',
            text: "Esta acción lo eliminará de la lista de personal activo.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#EF4444',
            cancelButtonColor: '#9CA3AF',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                formulario.submit();
            }
        });
    }
</script>
