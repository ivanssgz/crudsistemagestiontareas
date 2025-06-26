{{-- resources/views/tareas/index.blade.php --}}
<x-app-layout>
    {{-- ---------- ENCABEZADO ---------- --}}
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h1 class="text-xl sm:text-2xl font-semibold text-gray-800">
                Mis tareas
            </h1>

            <a href="{{ route('tareas.create') }}"
               class="px-6 py-2 rounded-3xl bg-gradient-to-b from-gray-900 to-black text-white
                      font-medium hover:shadow-md transition">
                + Nueva tarea
            </a>
        </div>
    </x-slot>

    {{-- ---------- CONTENEDOR VUE ---------- --}}
    <div id="tarea-index"
         class="max-w-5xl mx-auto space-y-6"
         data-initial='@json($tareas->values())'>

        @if(session('ok'))
            <div class="px-4 py-3 bg-green-100 text-green-800 rounded-lg shadow">
                {{ session('ok') }}
            </div>
        @endif

        <div class="overflow-x-auto bg-white shadow rounded-lg mt-8">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50 text-gray-600 uppercase text-sm tracking-wider">
                    <tr>
                        <th class="px-6 py-3 text-left">Título</th>
                        <th class="px-6 py-3 text-left">Estado</th>
                        <th class="px-6 py-3 text-right"></th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-100">
                    <tr v-for="t in tareas" :key="t.id">
                        <td class="px-6 py-4">@{{ t.titulo }}</td>

                        {{-- Estado visual: chip verde o rojo --}}
                        <td class="px-6 py-4">
                            <span
                                class="inline-flex px-2 py-1 rounded-full text-xs font-semibold"
                                :class="t.estado === 'completado'
                                        ? 'bg-green-100 text-green-800'
                                        : 'bg-red-100 text-red-800'">
                                @{{ t.estado.charAt(0).toUpperCase() + t.estado.slice(1) }}
                            </span>
                        </td>

                        <td class="px-6 py-4 text-right space-x-2 whitespace-nowrap">
                            <a :href="routeEdit(t.id)"
                               class="text-blue-600 hover:text-blue-900 font-medium">
                                Editar
                            </a>

                            <button @click="borrar(t)"
                                    class="text-red-600 hover:text-red-800 font-medium">
                                Borrar
                            </button>
                        </td>
                    </tr>

                    <tr v-if="!tareas.length">
                        <td colspan="3" class="px-6 py-8 text-center text-gray-500">
                            ¡No tienes tareas todavía!
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
