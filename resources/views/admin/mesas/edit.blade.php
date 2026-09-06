<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            {{ __('Editar Mesa') }}: {{ $mesa->name }}
        </h2>
    </x-slot>

    <div class="max-w-md mx-auto mt-6 p-6 bg-white dark:bg-dark-eval-1 rounded-lg shadow-lg">
        <form action="{{ route('admin.mesas.update', $mesa->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label class="block text-sm font-bold mb-2 dark:text-gray-300">Código de Sistema</label>
                <input type="text" value="{{ $mesa->code }}" disabled class="w-full border bg-gray-100 rounded px-3 py-2 dark:bg-gray-700 dark:text-gray-400 cursor-not-allowed">
            </div>

            <div class="mb-4">
                <label class="block text-sm font-bold mb-2 dark:text-gray-300">Nombre / Número</label>
                <input type="text" name="name" value="{{ $mesa->name }}" required class="w-full border rounded px-3 py-2 dark:bg-dark-eval-2 dark:border-gray-700 dark:text-white">
            </div>

            <div class="mb-4">
                <label class="block text-sm font-bold mb-2 dark:text-gray-300">Capacidad</label>
                <input type="number" name="capacity" value="{{ $mesa->capacity }}" min="1" required class="w-full border rounded px-3 py-2 dark:bg-dark-eval-2 dark:border-gray-700 dark:text-white">
            </div>

            <div class="mb-6">
                <label class="block text-sm font-bold mb-2 dark:text-gray-300">Estado Actual</label>
                <select name="status" class="w-full border rounded px-3 py-2 dark:bg-dark-eval-2 dark:border-gray-700 dark:text-white">
                    <option value="libre" {{ $mesa->status == 'libre' ? 'selected' : '' }}>🟢 Libre</option>
                    <option value="ocupada" {{ $mesa->status == 'ocupada' ? 'selected' : '' }}>🔴 Ocupada</option>
                    <option value="reservada" {{ $mesa->status == 'reservada' ? 'selected' : '' }}>🟠 Reservada</option>
                </select>
                <p class="text-xs text-orange-500 mt-1">⚠️ Cuidado al cambiar esto manualmente mientras hay clientes.</p>
            </div>

            <div class="flex justify-end gap-2">
                <a href="{{ route('admin.mesas.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300 font-bold">Cancelar</a>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 font-bold">Actualizar</button>
            </div>
        </form>
    </div>
</x-app-layout>
