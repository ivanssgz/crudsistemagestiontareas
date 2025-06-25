{{-- resources/views/tareas/index.blade.php --}}
<x-app-layout>
    {{-- ---------- SLOT DEL ENCABEZADO ---------- --}}
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
    {{-- ---------- /HEADER ---------- --}}

    {{-- ---------- CONTENIDO PRINCIPAL ---------- --}}
    <div class="max-w-5xl mx-auto space-y-6">
        {{-- Mensaje flash --}}
        @if(session('ok'))
            <div class="px-4 py-3 bg-green-100 text-green-800 rounded-lg shadow">
                {{ session('ok') }}
            </div>
        @endif

        {{-- Tabla de tareas --}}
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
                @forelse ($tareas as $tarea)
                    <tr>
                        <td class="px-6 py-4">{{ $tarea->titulo }}</td>
                        <td class="px-6 py-4">
                            <span class="inline-flex px-2 py-1 rounded-full text-xs font-semibold
                                 {{ $tarea->estado === 'completado'
                                        ? 'bg-green-100 text-green-800'
                                        : 'bg-yellow-100 text-yellow-800' }}">
                                {{ ucfirst($tarea->estado) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right space-x-2">
                            <a href="{{ route('tareas.edit', $tarea) }}"
                               class="text-blue-600 hover:text-blue-900 font-medium">
                                Editar
                            </a>

                            <form action="{{ route('tareas.destroy', $tarea) }}"
                                  method="POST"
                                  class="inline"
                                  onsubmit="return confirm('¿Eliminar la tarea?');">
                                @csrf
                                @method('DELETE')
                                <button class="text-red-600 hover:text-red-800 font-medium">
                                    Borrar
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="px-6 py-8 text-center text-gray-500">
                            ¡No tienes tareas todavía!
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
        {{-- /Tabla --}}
    </div>
    {{-- ---------- /CONTENIDO ---------- --}}
</x-app-layout>
