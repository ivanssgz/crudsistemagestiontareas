<x-app-layout>
    <x-slot name="header">Nueva tarea</x-slot>

    {{-- contenedor centrado --}}
    <div class="max-w-2xl mx-auto mt-8">   {{-- ← NUEVO --}}

        <form method="POST"
              action="{{ route('tareas.store') }}"
              class="space-y-6 bg-white shadow rounded-lg p-6">

            @csrf

            <div>
                <label class="block mb-1 font-medium">Título</label>
                <input name="titulo"
                       value="{{ old('titulo') }}"
                       class="w-full border rounded px-3 py-2"
                       required>
                @error('titulo')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block mb-1 font-medium">Descripción</label>
                <textarea name="descripcion"
                          rows="4"
                          class="w-full border rounded px-3 py-2">{{ old('descripcion') }}</textarea>
            </div>

            <div class="flex items-center gap-4">
                <button class="bg-indigo-600 text-white px-6 py-2 rounded hover:bg-indigo-700">
                    Guardar
                </button>
                <a href="{{ route('tareas.index') }}" class="text-gray-600 hover:underline">
                    Cancelar
                </a>
            </div>
        </form>

    </div> {{-- /contenedor --}}
</x-app-layout>
