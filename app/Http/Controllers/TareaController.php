<?php

namespace App\Http\Controllers;

use App\Models\Tarea;
use App\Http\Requests\StoreTareaRequest;
use App\Http\Requests\UpdateTareaRequest;

class TareaController extends Controller
{
    /* ---------- LISTAR ---------- */
    public function index()
    {
        $tareas = auth()->user()->tareas()->latest()->get();

        // Si la petición viene de Axios: devuelve JSON
        if (request()->wantsJson()) {
            return $tareas;          // Laravel lo serializa a JSON
        }

        return view('tareas.index', compact('tareas'));
    }

    /* ---------- FORM CREAR ---------- */
    public function create()
    {
        return view('tareas.create');
    }

    /* ---------- GUARDAR ---------- */
    public function store(StoreTareaRequest $request)
    {
        $data           = $request->validated();
        $data['estado'] = $data['estado'] ?? 'pendiente';

        $tarea = auth()->user()->tareas()->create($data);

        if ($request->wantsJson()) {
            return response()->json([
                'ok'    => true,
                'id'    => $tarea->id,
                'tarea' => $tarea,
            ]);
        }

        return redirect()
               ->route('tareas.index')
               ->with('ok', 'Tarea creada');
    }

    /* ---------- DETALLE (opcional) ---------- */
    public function show(Tarea $tarea)
    {
        $this->authorizeTarea($tarea);
        return view('tareas.show', compact('tarea'));
    }

    /* ---------- FORM EDITAR ---------- */
    public function edit(Tarea $tarea)
    {
        $this->authorizeTarea($tarea);
        return view('tareas.edit', compact('tarea'));
    }

    /* ---------- ACTUALIZAR ---------- */
    public function update(UpdateTareaRequest $request, Tarea $tarea)
    {
        $this->authorizeTarea($tarea);
        $tarea->update($request->validated());

        if ($request->wantsJson()) {
            return response()->json(['ok' => true]);
        }

        return redirect()
               ->route('tareas.index')
               ->with('ok', 'Tarea actualizada');
    }

    /* ---------- BORRAR ---------- */
    public function destroy(Tarea $tarea)
    {
        $this->authorizeTarea($tarea);
        $tarea->delete();

        if (request()->wantsJson()) {
            return response()->json(['ok' => true]);
        }

        return back()->with('ok', 'Tarea eliminada');
    }

    /** Protege acceso a tareas de otros usuarios */
    private function authorizeTarea(Tarea $tarea): void
    {
        abort_if($tarea->user_id !== auth()->id(), 403);
    }
}
