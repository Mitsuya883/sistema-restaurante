<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
            <h2 class="text-xl font-bold leading-tight text-gray-800 dark:text-gray-200 flex items-center gap-2">
                <div class="p-2 bg-orange-100 rounded-lg text-orange-600">
                    <i class="fa-solid fa-book-open"></i>
                </div>
                Libro de Reservas
            </h2>
            <a href="{{ route('reservations.create') }}" class="bg-gradient-to-r from-orange-600 to-orange-500 hover:from-orange-700 hover:to-orange-600 text-white px-5 py-2.5 rounded-xl font-bold shadow-lg shadow-orange-500/30 transition-all transform hover:-translate-y-0.5 flex items-center gap-2">
                <i class="fa-solid fa-plus"></i> Nueva Reserva
            </a>
        </div>
    </x-slot>

    <div class="p-6 max-w-7xl mx-auto">

        <div class="bg-white dark:bg-dark-eval-1 overflow-hidden rounded-2xl border border-gray-100 dark:border-gray-700">

            @if($reservations->isEmpty())
                <div class="flex flex-col items-center justify-center p-12 text-center">
                    <div class="w-16 h-16 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center mb-4">
                        <i class="fa-regular fa-calendar-xmark text-3xl text-gray-400"></i>
                    </div>
                    <h3 class="text-lg font-bold text-gray-600 dark:text-gray-300">No hay reservas pendientes</h3>
                    <p class="text-sm text-gray-400 mt-1">Tu agenda está libre por ahora.</p>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-800/50">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-black text-gray-400 uppercase tracking-wider">Fecha / Hora</th>
                                <th class="px-6 py-4 text-left text-xs font-black text-gray-400 uppercase tracking-wider">Cliente</th>
                                <th class="px-6 py-4 text-left text-xs font-black text-gray-400 uppercase tracking-wider">Mesa</th>
                                <th class="px-6 py-4 text-center text-xs font-black text-gray-400 uppercase tracking-wider">Pax</th>
                                <th class="px-6 py-4 text-center text-xs font-black text-gray-400 uppercase tracking-wider">Estado</th>
                                <th class="px-6 py-4 text-right text-xs font-black text-gray-400 uppercase tracking-wider">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-700 bg-white dark:bg-dark-eval-1">
                            @foreach($reservations as $res)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/30 transition-colors group">

                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center gap-3">
                                        <div class="flex flex-col items-center justify-center bg-blue-50 dark:bg-blue-900/20 text-blue-600 dark:text-blue-300 rounded-lg p-2 min-w-[50px]">
                                            <span class="text-xs font-bold uppercase">{{ \Carbon\Carbon::parse($res->reservation_date)->format('M') }}</span>
                                            <span class="text-lg font-black leading-none">{{ \Carbon\Carbon::parse($res->reservation_date)->format('d') }}</span>
                                        </div>
                                        <div>
                                            <div class="text-sm font-bold text-gray-800 dark:text-gray-200">
                                                {{ \Carbon\Carbon::parse($res->reservation_date)->format('l') }} </div>
                                            <div class="text-xs text-gray-500 flex items-center gap-1">
                                                <i class="fa-regular fa-clock"></i>
                                                {{ \Carbon\Carbon::parse($res->reservation_date)->format('h:i A') }}
                                            </div>
                                        </div>
                                    </div>
                                </td>

                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <div>
                                            <div class="text-sm font-bold text-gray-900 dark:text-white">{{ $res->customer->name }}</div>
                                            <a href="tel:{{ $res->customer->phone }}" class="text-xs text-gray-500 hover:text-orange-500 transition-colors flex items-center gap-1">
                                                <i class="fa-solid fa-phone text-[10px]"></i>
                                                {{ $res->customer->phone }}
                                            </a>
                                        </div>
                                    </div>
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 dark:text-gray-300">
                                    @if($res->table)
                                        <span class="flex items-center gap-2 font-medium">
                                            <i class="fa-solid fa-chair text-gray-400"></i> {{ $res->table->name }}
                                        </span>
                                    @else
                                        <span class="text-red-400 text-xs italic">Sin Asignar</span>
                                    @endif
                                </td>

                                <td class="px-6 py-4 text-center whitespace-nowrap text-sm text-gray-600 dark:text-gray-300 font-bold">
                                    <span class="bg-gray-100 dark:bg-gray-700 px-2 py-1 rounded-md text-xs">
                                        <i class="fa-solid fa-user-group text-gray-400 mr-1"></i> {{ $res->guest_count }}
                                    </span>
                                </td>

                                <td class="px-6 py-4 text-center whitespace-nowrap">
                                    @switch($res->status)
                                        @case('confirmada')
                                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400 border border-green-200 dark:border-green-800">
                                                Confirmada
                                            </span>
                                        @break
                                        @case('pendiente')
                                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400 border border-blue-200 dark:border-blue-800">
                                                Pendiente
                                            </span>
                                        @break
                                        @case('cancelada')
                                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400 border border-red-200 dark:border-red-800">
                                                Cancelada
                                            </span>
                                        @break
                                        @default
                                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full bg-gray-100 text-gray-700 dark:bg-gray-700 dark:text-gray-300">
                                                {{ ucfirst($res->status) }}
                                            </span>
                                    @endswitch
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex items-center justify-end gap-2 opacity-80 group-hover:opacity-100 transition-opacity">

                                        @if($res->status == 'pendiente')
                                        <form action="{{ route('reservations.confirm', $res->id) }}" method="POST" class="inline-block">
                                            @csrf
                                            <button type="submit" class="w-8 h-8 rounded-full bg-green-50 text-green-600 hover:bg-green-100 hover:text-green-700 flex items-center justify-center transition-all hover:scale-110 shadow-sm border border-green-200" title="Confirmar Reserva">
                                                <i class="fa-solid fa-check"></i>
                                            </button>
                                        </form>
                                        @endif

                                        @if(in_array($res->status, ['pendiente', 'confirmada']))
                                        <a href="{{ route('reservations.edit', $res->id) }}" class="w-8 h-8 rounded-full bg-indigo-50 text-indigo-600 hover:bg-indigo-100 hover:text-indigo-700 flex items-center justify-center transition-all hover:scale-110 shadow-sm border border-indigo-200" title="Editar Reserva">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </a>
                                        @endif

                                        @if(in_array($res->status, ['pendiente', 'confirmada']))
                                        <form action="{{ route('reservations.cancel', $res->id) }}" method="POST" class="inline-block">
                                            @csrf
                                            @method('PUT')
                                            <button type="button" onclick="confirmarCancelacion(event)" class="w-8 h-8 rounded-full bg-red-50 text-red-600 hover:bg-red-100 hover:text-red-700 flex items-center justify-center transition-all hover:scale-110 shadow-sm border border-red-200" title="Cancelar Reserva">
                                                <i class="fa-solid fa-ban"></i>
                                            </button>
                                        </form>
                                        @endif

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
    // Tu lógica de SweetAlert se mantiene igual, solo asegúrate de que se cargue
    document.addEventListener('DOMContentLoaded', function() {
        // ... (Tu código existente para mostrar mensajes de sesión)
        const successMessage = "{{ session('status') }}";
        const errorMessage = "{{ session('error') }}";
        if (successMessage) {
             Swal.fire({ title: '¡Operación Exitosa!', text: successMessage, icon: 'success', confirmButtonColor: '#9333ea' });
        }
        if (errorMessage) {
             Swal.fire({ title: '¡Error!', text: errorMessage, icon: 'error', confirmButtonColor: '#ef4444' });
        }
    });

    function confirmarCancelacion(event) {
        // ... (Tu código existente para confirmar cancelación)
        const form = event.target.closest('form'); // Pequeña mejora: usar closest por si el click cae en el ícono <i>

        Swal.fire({
            title: '¿Cancelar Reserva?',
            text: "Esta acción liberará la mesa inmediatamente.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            cancelButtonColor: '#9ca3af',
            confirmButtonText: 'Sí, cancelar',
            cancelButtonText: 'Volver'
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    }
</script>
