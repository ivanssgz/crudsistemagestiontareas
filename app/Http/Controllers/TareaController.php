<?php

namespace App\Http\Controllers;

use App\Models\Tarea;
use App\Http\Requests\StoreTareaRequest;
use App\Http\Requests\UpdateTareaRequest;

class TareaController extends Controller
{
    /* Listar tareas del usuario */
    public function index()
    {
        $tareas = auth()->user()->tareas()->latest()->get();
        return view('tareas.index', compact('tareas'));
    }

    /* Formulario crear */
    public function create()
    {
        return view('tareas.create');
    }

    /* Guardar nueva tarea */
    public function store(StoreTareaRequest $request)
    {
        auth()->user()->tareas()->create($request->validated());
        return redirect()->route('tareas.index')->with('ok', 'Tarea creada');
    }

    /* Mostrar detalle (opcional) */
    public function show(Tarea $tarea)
    {
        $this->authorizeTarea($tarea);
        return view('tareas.show', compact('tarea'));
    }

    /* Formulario editar */
    public function edit(Tarea $tarea)
    {
        $this->authorizeTarea($tarea);
        return view('tareas.edit', compact('tarea'));
    }

    /* Actualizar */
    public function update(UpdateTareaRequest $request, Tarea $tarea)
    {
        $this->authorizeTarea($tarea);
        $tarea->update($request->validated());
        return redirect()->route('tareas.index')->with('ok', 'Tarea actualizada');
    }

    /* Borrar */
    public function destroy(Tarea $tarea)
    {
        $this->authorizeTarea($tarea);
        $tarea->delete();
        return back()->with('ok', 'Tarea eliminada');
    }

    /** Protege acceso a tareas de otros usuarios */
    private function authorizeTarea(Tarea $tarea): void
    {
        abort_if($tarea->user_id !== auth()->id(), 403);
    }
}

