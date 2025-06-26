<x-app-layout>
    <x-slot name="header">Editar tarea</x-slot>

    {{-- tarjeta centrada --}}
    <div class="max-w-2xl mx-auto mt-8">

        <div  id="tarea-edit"
              data-id="{{ $tarea->id }}"
              data-initial='{!! json_encode($tarea->only(["titulo","descripcion","estado"])) !!}'
              class="space-y-6 bg-white shadow rounded-lg p-6">

            {{-- Vue intercepta el envío --}}
            <form @submit.prevent="update" class="space-y-6">
                @csrf @method('PUT')

                {{-- Título --}}
                <div>
                    <label class="block mb-1 font-medium">Título</label>
                    <input v-model="form.titulo"
                           class="w-full border rounded px-3 py-2"
                           required>
                    @error('titulo')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Descripción --}}
                <div>
                    <label class="block mb-1 font-medium">Descripción</label>
                    <textarea v-model="form.descripcion"
                              rows="4"
                              class="w-full border rounded px-3 py-2"></textarea>
                </div>

                {{-- Estado --}}
                <div>
                    <label class="block mb-1 font-medium">Estado</label>
                    <select v-model="form.estado"
                            class="border rounded px-3 py-2">
                        <option value="pendiente">Pendiente</option>
                        <option value="completado">Completado</option>
                    </select>
                </div>

                {{-- Botones --}}
                <div class="flex items-center gap-4">
                    <button :disabled="loading"
                            class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2 rounded">
                        Actualizar
                    </button>

                    <a href="{{ route('tareas.index') }}"
                       class="text-gray-600 hover:underline">
                        Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>

