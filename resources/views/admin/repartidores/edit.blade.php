<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            {{ __('Editar Datos del Repartidor') }}
        </h2>
    </x-slot>

    <div class="max-w-md mx-auto mt-6 p-6 bg-white dark:bg-dark-eval-1 rounded-lg shadow-lg">
        <form action="{{ route('admin.repartidores.update', $repartidor->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label class="block text-sm font-bold mb-2 dark:text-gray-300">Nombre</label>
                <input type="text" name="nombre" value="{{ $repartidor->nombre }}" required
                       class="w-full border rounded px-3 py-2 dark:bg-dark-eval-2 dark:border-gray-700 dark:text-white">
            </div>

            <div class="mb-4">
                <label class="block text-sm font-bold mb-2 dark:text-gray-300">Teléfono</label>
                <input type="tel" name="telefono" value="{{ $repartidor->telefono }}" maxlength="9" pattern="[0-9]{9}"
                       class="w-full border rounded px-3 py-2 dark:bg-dark-eval-2 dark:border-gray-700 dark:text-white"
                       oninput="this.value = this.value.replace(/[^0-9]/g, '')">
            </div>

            <div class="mb-4">
                <label class="block text-sm font-bold mb-2 dark:text-gray-300">Placa</label>
                <input type="text" name="placa_vehiculo" value="{{ $repartidor->placa_vehiculo }}"
                       class="w-full border rounded px-3 py-2 uppercase dark:bg-dark-eval-2 dark:border-gray-700 dark:text-white">
            </div>

            <div class="mb-6 bg-gray-50 dark:bg-gray-800 p-3 rounded border dark:border-gray-700">
                <label class="flex items-center cursor-pointer">
                    <input type="hidden" name="activo" value="0">
                    <input type="checkbox" name="activo" value="1" {{ $repartidor->activo ? 'checked' : '' }} class="form-checkbox h-5 w-5 text-blue-600">
                    <span class="ml-2 text-gray-700 dark:text-gray-300 font-bold">¿Está Activo (Trabajando)?</span>
                </label>
                <p class="text-xs text-gray-500 mt-1 ml-7">Si desactivas esto, no aparecerá en la lista para asignarle pedidos.</p>
            </div>

            <div class="flex justify-end gap-2">
                <a href="{{ route('admin.repartidores.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300 font-bold">Cancelar</a>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 font-bold shadow">Actualizar</button>
            </div>
        </form>
    </div>
</x-app-layout>
