<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <div class="p-2 bg-orange-100 dark:bg-orange-900 rounded-lg text-orange-600 dark:text-orange-300">
                <i class="fa-solid fa-pen-to-square text-xl"></i>
            </div>
            <h2 class="text-xl font-bold leading-tight text-gray-800 dark:text-gray-200">
                {{ __('Editar Reserva') }} <span class="text-gray-400 font-medium text-sm">#{{ $reservation->id }}</span>
            </h2>
        </div>
    </x-slot>

    <div class="p-6 max-w-4xl mx-auto">

        <div class="bg-white dark:bg-dark-eval-1 rounded-2xl shadow-md border border-gray-100 dark:border-gray-700 overflow-hidden">

            <form method="POST" action="{{ route('reservations.update', $reservation->id) }}" class="p-6 md:p-8">
                @csrf
                @method('PUT')

                @if ($errors->any())
                <div class="mb-8 p-4 bg-red-50 dark:bg-red-900/20 border border-red-100 dark:border-red-800 rounded-xl flex items-start gap-3">
                    <i class="fa-solid fa-triangle-exclamation text-red-500 mt-0.5"></i>
                    <div>
                        <h4 class="font-bold text-red-700 dark:text-red-400 text-sm">Por favor corrige los siguientes errores:</h4>
                        <ul class="list-disc list-inside text-xs text-red-600 dark:text-red-300 mt-1">
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                @endif

                <div class="mb-8">
                    <h3 class="flex items-center gap-2 text-sm font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wide border-b border-gray-100 dark:border-gray-700 pb-2 mb-4">
                        <i class="fa-solid fa-user-tag text-orange-500"></i> Información de Contacto
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="relative">
                            <label class="block text-xs font-bold text-gray-500 dark:text-gray-400 mb-1.5 ml-1">Cliente</label>
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400 group-focus-within:text-orange-500">
                                    <i class="fa-solid fa-user"></i>
                                </div>
                                <input type="text" name="client_name" value="{{ old('client_name', $reservation->customer->name) }}" required
                                    class="w-full pl-10 py-2.5 text-sm border-gray-200 dark:border-gray-600 rounded-lg bg-gray-50 dark:bg-dark-eval-2 text-gray-800 dark:text-gray-200 focus:ring-2 focus:ring-orange-500/50 focus:border-orange-500 transition-all shadow-sm placeholder-gray-400">
                            </div>
                        </div>

                        <div class="relative">
                            <label class="block text-xs font-bold text-gray-500 dark:text-gray-400 mb-1.5 ml-1">Teléfono <span class="text-red-500">*</span></label>
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400 group-focus-within:text-orange-500">
                                    <i class="fa-solid fa-phone"></i>
                                </div>
                                <input type="tel" name="client_phone" value="{{ old('client_phone', $reservation->customer->phone) }}" required maxlength="9" pattern="[0-9]{9}" oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                    class="w-full pl-10 py-2.5 text-sm border-gray-200 dark:border-gray-600 rounded-lg bg-gray-50 dark:bg-dark-eval-2 text-gray-800 dark:text-gray-200 focus:ring-2 focus:ring-orange-500/50 focus:border-orange-500 transition-all shadow-sm placeholder-gray-400">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mb-8">
                    <h3 class="flex items-center gap-2 text-sm font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wide border-b border-gray-100 dark:border-gray-700 pb-2 mb-4">
                        <i class="fa-solid fa-calendar-check text-orange-500"></i> Detalles de la Cita
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <label class="block text-xs font-bold text-gray-500 dark:text-gray-400 mb-1.5 ml-1">Fecha <span class="text-red-500">*</span></label>
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400 group-focus-within:text-orange-500">
                                    <i class="fa-regular fa-calendar-days"></i>
                                </div>
                                <input type="date" name="reservation_date" value="{{ $fecha }}" min="{{ date('Y-m-d') }}" required
                                    class="w-full pl-10 py-2.5 text-sm border-gray-200 dark:border-gray-600 rounded-lg bg-gray-50 dark:bg-dark-eval-2 text-gray-800 dark:text-gray-200 focus:ring-2 focus:ring-orange-500/50 focus:border-orange-500 transition-all shadow-sm">
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-500 dark:text-gray-400 mb-1.5 ml-1">Hora <span class="text-red-500">*</span></label>
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400 group-focus-within:text-orange-500">
                                    <i class="fa-regular fa-clock"></i>
                                </div>
                                <input type="time" name="time" value="{{ $hora }}" min="12:00" max="22:00" required
                                    class="w-full pl-10 py-2.5 text-sm border-gray-200 dark:border-gray-600 rounded-lg bg-gray-50 dark:bg-dark-eval-2 text-gray-800 dark:text-gray-200 focus:ring-2 focus:ring-orange-500/50 focus:border-orange-500 transition-all shadow-sm">
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-500 dark:text-gray-400 mb-1.5 ml-1">N° Personas</label>
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400 group-focus-within:text-orange-500">
                                    <i class="fa-solid fa-user-group"></i>
                                </div>
                                <input type="number" name="guest_count" value="{{ $reservation->guest_count }}" min="1" required
                                    class="w-full pl-10 py-2.5 text-sm border-gray-200 dark:border-gray-600 rounded-lg bg-gray-50 dark:bg-dark-eval-2 text-gray-800 dark:text-gray-200 focus:ring-2 focus:ring-orange-500/50 focus:border-orange-500 transition-all shadow-sm">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mb-6">
                    <h3 class="flex items-center gap-2 text-sm font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wide border-b border-gray-100 dark:border-gray-700 pb-2 mb-4">
                        <i class="fa-solid fa-chair text-orange-500"></i> Ubicación
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-xs font-bold text-gray-500 dark:text-gray-400 mb-1.5 ml-1">Mesa Asignada</label>
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400 group-focus-within:text-orange-500">
                                    <i class="fa-solid fa-utensils"></i>
                                </div>
                                <select name="table_id" class="w-full pl-10 py-2.5 text-sm border-gray-200 dark:border-gray-600 rounded-lg bg-gray-50 dark:bg-dark-eval-2 text-gray-800 dark:text-gray-200 focus:ring-2 focus:ring-orange-500/50 focus:border-orange-500 transition-all shadow-sm appearance-none">
                                    <option value="">-- Sin asignar mesa --</option>
                                    @foreach($tables as $table)
                                    <option value="{{ $table->id }}" {{ $reservation->table_id == $table->id ? 'selected' : '' }}>
                                        {{ $table->name }} (Cap: {{ $table->capacity }})
                                        @if($table->id != $reservation->table_id && $table->status != 'libre')
                                         - [OCUPADA/RESERVADA]
                                        @endif
                                    </option>
                                    @endforeach
                                </select>
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none text-gray-400">
                                    <i class="fa-solid fa-chevron-down text-xs"></i>
                                </div>
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-500 dark:text-gray-400 mb-1.5 ml-1">Notas Adicionales</label>
                            <div class="relative group">
                                <div class="absolute top-3 left-3 flex items-center pointer-events-none text-gray-400 group-focus-within:text-orange-500">
                                    <i class="fa-regular fa-comment-dots"></i>
                                </div>
                                <textarea name="notes" rows="1" placeholder="Cumpleaños, alergias, etc."
                                    class="w-full pl-10 py-2.5 text-sm border-gray-200 dark:border-gray-600 rounded-lg bg-gray-50 dark:bg-dark-eval-2 text-gray-800 dark:text-gray-200 focus:ring-2 focus:ring-orange-500/50 focus:border-orange-500 transition-all shadow-sm resize-none">{{ $reservation->notes }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row justify-end items-center gap-3 pt-6 border-t border-gray-100 dark:border-gray-700 mt-6">
                    <a href="{{ route('reservations.index') }}" class="w-full sm:w-auto px-5 py-2.5 bg-white border border-gray-300 text-gray-700 rounded-xl hover:bg-gray-50 font-bold transition-colors text-center shadow-sm dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300 dark:hover:bg-gray-600">
                        Cancelar
                    </a>

                    <button type="submit" class="w-full sm:w-auto px-6 py-2.5 bg-gradient-to-r from-orange-600 to-orange-500 hover:from-orange-700 hover:to-orange-600 text-white rounded-xl shadow-md hover:shadow-lg font-bold transition-all transform hover:-translate-y-0.5 flex items-center justify-center gap-2">
                        <i class="fa-regular fa-floppy-disk"></i>
                        Guardar Cambios
                    </button>
                </div>

            </form>
        </div>
    </div>
</x-app-layout>
