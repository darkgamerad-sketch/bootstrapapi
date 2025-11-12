<?php

namespace App\Http\Controllers;

use App\Models\Tarea;
use Illuminate\Http\Request;
use App\Http\Resources\TareaResource;

class TareaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Excluir tareas eliminadas (soft deleted)
        $tareas = Tarea::whereNull('deleted_at')->get();
        return view('tareas.index', compact('tareas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('tareas.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:60',
            'descripcion' => 'nullable|string',
            'fecha_limite' => 'required|date',
            'urgencia' => 'required|integer|in:0,1,2'
        ]);

        Tarea::create($validated);

        return redirect()->route('tareas.index')->with('success', 'Tarea creada exitosamente!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Tarea $tarea)
    {
        return view('tareas.show', compact('tarea'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tarea $tarea)
    {
        return view('tareas.edit', compact('tarea'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tarea $tarea)
    {
        $request->validate([
            'nombre' => 'required|string|max:60',
            'descripcion' => 'nullable|string',
            'fecha_limite' => 'required|date',
            'urgencia' => 'required|integer|in:0,1,2',
            'finalizada' => 'sometimes|boolean'
        ]);

        $tarea->update([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'fecha_limite' => $request->fecha_limite,
            'urgencia' => $request->urgencia,
            'finalizada' => $request->finalizada ?? 0
        ]);

        return redirect()->route('tareas.index')->with('success', 'Tarea actualizada exitosamente!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tarea $tarea)
    {
        $tarea->delete();

        return redirect()->route('tareas.index')->with('success', 'Tarea eliminada exitosamente!');
    }

    // ========== MÉTODOS API ==========

    public function indexApi()
    {
        $tareas = Tarea::whereNull('deleted_at')->get();

        // Formatear las tareas manualmente
        $tareasFormateadas = $tareas->map(function ($tarea) {
            return [
                'id' => $tarea->id,
                'nombre' => $tarea->nombre,
                'descripcion' => $tarea->descripcion,
                'finalizada' => (bool)$tarea->finalizada,
                'fecha_limite' => $tarea->fecha_limite->toISOString(),
                'fecha_limite_formatted' => $tarea->fecha_limite->format('d/m/Y H:i'),
                'urgencia' => $tarea->urgencia,
                'urgencia_texto' => $tarea->urgencia_texto,
                'urgencia_clase' => $tarea->urgencia_clase,
                'created_at' => $tarea->created_at->toISOString(),
                'updated_at' => $tarea->updated_at->toISOString(),
            ];
        });

        return response()->json($tareasFormateadas);
    }

    /**
     * Store a newly created resource in storage for API.
     */
    public function storeApi(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:60',
            'descripcion' => 'nullable|string',
            'fecha_limite' => 'required|date',
            'urgencia' => 'required|integer|in:0,1,2'
        ]);

        $tarea = Tarea::create($validated);

        // Devolver la tarea formateada
        return response()->json([
            'id' => $tarea->id,
            'nombre' => $tarea->nombre,
            'descripcion' => $tarea->descripcion,
            'finalizada' => (bool)$tarea->finalizada,
            'fecha_limite' => $tarea->fecha_limite->toISOString(),
            'fecha_limite_formatted' => $tarea->fecha_limite->format('d/m/Y H:i'),
            'urgencia' => $tarea->urgencia,
            'urgencia_texto' => $tarea->urgencia_texto,
            'urgencia_clase' => $tarea->urgencia_clase,
            'created_at' => $tarea->created_at->toISOString(),
            'updated_at' => $tarea->updated_at->toISOString(),
        ]);
    }

    /**
     * Display the specified resource for API.
     */
    public function showApi(Tarea $tarea)
    {
        return response()->json([
            'id' => $tarea->id,
            'nombre' => $tarea->nombre,
            'descripcion' => $tarea->descripcion,
            'finalizada' => (bool)$tarea->finalizada,
            'fecha_limite' => $tarea->fecha_limite->toISOString(),
            'fecha_limite_formatted' => $tarea->fecha_limite->format('d/m/Y H:i'),
            'urgencia' => $tarea->urgencia,
            'urgencia_texto' => $tarea->urgencia_texto,
            'urgencia_clase' => $tarea->urgencia_clase,
            'created_at' => $tarea->created_at->toISOString(),
            'updated_at' => $tarea->updated_at->toISOString(),
        ]);
    }

    /**
     * Update the specified resource in storage for API.
     */
    public function updateApi(Request $request, Tarea $tarea)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:60',
            'descripcion' => 'nullable|string',
            'fecha_limite' => 'required|date',
            'urgencia' => 'required|integer|in:0,1,2',
            'finalizada' => 'sometimes|boolean'
        ]);

        $tarea->update($validated);

        // Devolver la tarea actualizada formateada
        return response()->json([
            'id' => $tarea->id,
            'nombre' => $tarea->nombre,
            'descripcion' => $tarea->descripcion,
            'finalizada' => (bool)$tarea->finalizada,
            'fecha_limite' => $tarea->fecha_limite->toISOString(),
            'fecha_limite_formatted' => $tarea->fecha_limite->format('d/m/Y H:i'),
            'urgencia' => $tarea->urgencia,
            'urgencia_texto' => $tarea->urgencia_texto,
            'urgencia_clase' => $tarea->urgencia_clase,
            'created_at' => $tarea->created_at->toISOString(),
            'updated_at' => $tarea->updated_at->toISOString(),
        ]);
    }

    /**
     * Remove the specified resource from storage for API.
     */
    public function destroyApi(Tarea $tarea)
    {
        $tarea->delete();

        return response()->json([
            'message' => 'Tarea eliminada exitosamente'
        ]);
    }
}
