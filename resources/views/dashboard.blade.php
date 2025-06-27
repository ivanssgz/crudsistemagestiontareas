<x-app-layout>
    <x-slot name="header">Dashboard</x-slot>

    <div id="tarea-stats"
        data-url="{{ route('tareas.stats') }}"
        class="w-full max-w-md"></div>

    <style>
        #chartTareas { max-width: 100%; height: 16rem; }
    </style>

</x-app-layout>


