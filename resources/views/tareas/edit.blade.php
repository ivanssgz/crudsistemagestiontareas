<x-app-layout>
    <x-slot name="header">Editar tarea</x-slot>

    <form method="POST" action="{{ route('tareas.update', $tarea) }}" class="max-w-xl space-y-6">
        @csrf @method('PUT')

        <div>
            <label class="block mb-1 font-medium">Título</label>
            <input name="titulo" value="{{ old('titulo', $tarea->titulo) }}" class="w-full border rounded px-3 py-2" required>
            @error('titulo') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block mb-1 font-medium">Descripción</label>
            <textarea name="descripcion" rows="4" class="w-full border rounded px-3 py-2">{{ old('descripcion', $tarea->descripcion) }}</textarea>
        </div>

        <div>
            <label class="block mb-1 font-medium">Estado</label>
            <select name="estado" class="border rounded px-3 py-2">
                <option value="pendiente"  {{ $tarea->estado==='pendiente'  ? 'selected' : '' }}>Pendiente</option>
                <option value="completado" {{ $tarea->estado==='completado' ? 'selected' : '' }}>Completado</option>
            </select>
        </div>

        <button class="bg-indigo-600 text-white px-6 py-2 rounded hover:bg-indigo-700">Actualizar</button>
        <a href="{{ route('tareas.index') }}" class="ml-4 text-gray-600 hover:underline">Cancelar</a>
    </form>
</x-app-layout>