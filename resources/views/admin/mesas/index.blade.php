<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
            <h2 class="text-xl font-bold leading-tight text-gray-800 dark:text-gray-200 flex items-center gap-2">
                <div class="p-2 bg-blue-100 dark:bg-blue-900 rounded-lg text-blue-600 dark:text-blue-300">
                    <i class="fa-solid fa-chair"></i>
                </div>
                Gestión de Mesas
            </h2>
            <a href="{{ route('admin.mesas.create') }}" class="bg-gradient-to-r from-blue-600 to-blue-500 hover:from-blue-700 hover:to-blue-600 text-white px-5 py-2.5 rounded-xl font-bold shadow-lg shadow-blue-500/30 transition-all transform hover:-translate-y-0.5 flex items-center gap-2">
                <i class="fa-solid fa-plus"></i> Nueva Mesa
            </a>
        </div>
    </x-slot>

    <div class="p-6 max-w-7xl mx-auto">

        <div class="bg-white dark:bg-dark-eval-1 overflow-hidden shadow-xl rounded-2xl border border-gray-100 dark:border-gray-700">

            @if($tables->isEmpty())
                <div class="flex flex-col items-center justify-center p-12 text-center">
                    <div class="w-16 h-16 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center mb-4">
                        <i class="fa-solid fa-layer-group text-3xl text-gray-400"></i>
                    </div>
                    <h3 class="text-lg font-bold text-gray-600 dark:text-gray-300">No hay mesas registradas</h3>
                    <p class="text-sm text-gray-400 mt-1">Comienza creando el mapa de tu restaurante.</p>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-800/50">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-black text-gray-400 uppercase tracking-wider">Código</th>
                                <th class="px-6 py-4 text-left text-xs font-black text-gray-400 uppercase tracking-wider">Nombre / N°</th>
                                <th class="px-6 py-4 text-center text-xs font-black text-gray-400 uppercase tracking-wider">Capacidad</th>
                                <th class="px-6 py-4 text-center text-xs font-black text-gray-400 uppercase tracking-wider">Estado Actual</th>
                                <th class="px-6 py-4 text-right text-xs font-black text-gray-400 uppercase tracking-wider">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-700 bg-white dark:bg-dark-eval-1">
                            @foreach($tables as $mesa)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/30 transition-colors group">

                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="font-mono text-xs font-bold text-blue-600 dark:text-blue-400 bg-blue-50 dark:bg-blue-900/20 px-2 py-1 rounded border border-blue-100 dark:border-blue-800">
                                        {{ $mesa->code ?? 'ME'.str_pad($mesa->id, 2, '0', STR_PAD_LEFT) }}
                                    </span>
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-bold text-gray-800 dark:text-gray-200 flex items-center gap-2">
                                        <i class="fa-solid fa-utensils text-gray-300"></i>
                                        {{ $mesa->name }}
                                    </div>
                                </td>

                                <td class="px-6 py-4 text-center whitespace-nowrap text-sm text-gray-600 dark:text-gray-300">
                                    <div class="inline-flex items-center gap-1 bg-gray-100 dark:bg-gray-700 px-2.5 py-1 rounded-full text-xs font-bold">
                                        <i class="fa-solid fa-users text-gray-400"></i> {{ $mesa->capacity }}
                                    </div>
                                </td>

                                <td class="px-6 py-4 text-center whitespace-nowrap">
                                    @if($mesa->status == 'libre')
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400 border border-green-200 dark:border-green-800 shadow-sm">
                                            <i class="fa-solid fa-circle text-[6px] self-center mr-1.5"></i> Libre
                                        </span>
                                    @elseif($mesa->status == 'ocupada')
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400 border border-red-200 dark:border-red-800 shadow-sm">
                                            <i class="fa-solid fa-circle text-[6px] self-center mr-1.5"></i> Ocupada
                                        </span>
                                    @else
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full bg-orange-100 text-orange-700 dark:bg-orange-900/30 dark:text-orange-400 border border-orange-200 dark:border-orange-800 shadow-sm">
                                            <i class="fa-solid fa-clock text-[8px] self-center mr-1.5"></i> Reservada
                                        </span>
                                    @endif
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex items-center justify-end gap-2 opacity-80 group-hover:opacity-100 transition-opacity">

                                        <a href="{{ route('admin.mesas.edit', $mesa->id) }}" class="w-8 h-8 rounded-full bg-indigo-50 text-indigo-600 hover:bg-indigo-100 hover:text-indigo-700 flex items-center justify-center transition-all hover:scale-110 shadow-sm border border-indigo-200" title="Editar Mesa">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </a>

                                        <form action="{{ route('admin.mesas.destroy', $mesa->id) }}" method="POST" class="inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" onclick="confirmarEliminacion(event)" class="w-8 h-8 rounded-full bg-red-50 text-red-600 hover:bg-red-100 hover:text-red-700 flex items-center justify-center transition-all hover:scale-110 shadow-sm border border-red-200" title="Eliminar Mesa">
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
        const successMessage = "{{ session('status') }}";
        const errorMessage = "{{ session('error') }}";

        if (successMessage) {
             Swal.fire({
                 title: '¡Excelente!',
                 text: successMessage,
                 icon: 'success',
                 confirmButtonColor: '#2563eb',
                 timer: 2000,
                 showConfirmButton: false
             });
        }

        if (errorMessage) {
             Swal.fire({
                 title: '¡Error!',
                 text: errorMessage,
                 icon: 'error',
                 confirmButtonColor: '#ef4444'
             });
        }
    });

    function confirmarEliminacion(event) {
        event.preventDefault();
        const form = event.target.closest('form');

        Swal.fire({
            title: '¿Eliminar esta mesa?',
            text: "Esta acción no se puede deshacer. Se perderá el historial asociado si no está protegido.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            cancelButtonColor: '#9ca3af',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    }
</script>
