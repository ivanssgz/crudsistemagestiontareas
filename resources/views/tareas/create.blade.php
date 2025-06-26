<x-app-layout>
    <x-slot name="header">Nueva tarea</x-slot>

    <div class="max-w-2xl mx-auto mt-8">

        <div id="tarea-create"
             data-url="{{ route('tareas.store') }}"
             class="space-y-6 bg-white shadow rounded-lg p-6">
        </div>

    </div>
</x-app-layout>

