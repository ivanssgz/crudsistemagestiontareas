<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>TaskFlow – Mis tareas</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet"/>

    <!-- Styles -->
    @vite(['resources/css/app.css'])
</head>
<body>
<div class="min-h-screen bg-gray-100">
    <div class="px-2 md:px-20 pt-6 max-w-7xl mx-auto">


        <!-- cabecera -->
        <div class="flex items-center justify-between mt-16 mb-6">
            <h1 class="text-3xl md:text-4xl font-bold text-gray-900">
                Mis tareas
            </h1>
            <a href="{{ route('tareas.create') }}"
               class="px-6 py-3 rounded-3xl font-medium bg-gradient-to-b from-gray-900 to-black text-white hover:shadow-md transition duration-200 ease-in-out">
                + Nueva tarea
            </a>
        </div>

        <!-- Mensaje de éxito -->
        @if(session('ok'))
            <div
                class="mb-6 px-4 py-3 rounded-lg bg-green-100 text-green-800 font-medium shadow-sm">
                {{ session('ok') }}
            </div>
        @endif

        <!-- tabla de tareas -->
        <div class="overflow-x-auto bg-white shadow rounded-lg">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50 text-gray-600 uppercase text-sm tracking-wider">
                <tr>
                    <th class="px-6 py-3 text-left">Título</th>
                    <th class="px-6 py-3 text-left">Estado</th>
                    <th class="px-6 py-3 text-right"></th>
                </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                @forelse($tareas as $tarea)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            {{ $tarea->titulo }}
                        </td>
                        <td class="px-6 py-4">
                            <span
                                class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold
                                {{ $tarea->estado === 'completado' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                {{ ucfirst($tarea->estado) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right space-x-2">
                            <a href="{{ route('tareas.edit', $tarea) }}"
                               class="text-blue-600 hover:text-blue-900 font-medium">Editar</a>

                            <form action="{{ route('tareas.destroy', $tarea) }}"
                                  method="POST"
                                  class="inline"
                                  onsubmit="return confirm('¿Eliminar la tarea?');">
                                @csrf @method('DELETE')
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
        <!-- /tabla de tareas -->

    </div>
</div>
</body>
</html>
