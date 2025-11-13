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
        // Excluir tareas eliminadas (soft deleted) con PAGINACIÓN - ORDEN ASCENDENTE
        $tareas = Tarea::whereNull('deleted_at')
                       ->orderBy('id', 'asc') // ← CAMBIADO A 'asc' PARA ID 1, 2, 3...
                       ->paginate(5); // 5 tareas por página

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

    public function indexApi(Request $request)
    {
        // Obtener parámetros de paginación
        $perPage = $request->get('per_page', 5);
        $page = $request->get('page', 1);

        // Paginar tareas excluyendo eliminadas - ORDEN ASCENDENTE
        $tareas = Tarea::whereNull('deleted_at')
                       ->orderBy('id', 'asc') // ← MANTENIDO COMO 'asc' PARA ID 1, 2, 3...
                       ->paginate($perPage, ['*'], 'page', $page);

        // Resto del código igual...
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

        return response()->json([
            'data' => $tareasFormateadas,
            'pagination' => [
                'current_page' => $tareas->currentPage(),
                'per_page' => $tareas->perPage(),
                'total' => $tareas->total(),
                'last_page' => $tareas->lastPage(),
                'from' => $tareas->firstItem(),
                'to' => $tareas->lastItem(),
                'links' => [
                    'first' => $tareas->url(1),
                    'last' => $tareas->url($tareas->lastPage()),
                    'prev' => $tareas->previousPageUrl(),
                    'next' => $tareas->nextPageUrl(),
                ]
            ]
        ]);
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
    public function showApi($id) // CAMBIADO: De Tarea $tarea a $id
    {
        try {
            // Buscar la tarea específica
            $tarea = Tarea::whereNull('deleted_at')->find($id);

            if (!$tarea) {
                return response()->json([
                    'error' => 'Tarea no encontrada'
                ], 404);
            }

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

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Error interno del servidor'
            ], 500);
        }
    }

    /**
     * Update the specified resource in storage for API.
     */
    public function updateApi(Request $request, $id) // CAMBIADO: De Tarea $tarea a $id
    {
        try {
            $tarea = Tarea::whereNull('deleted_at')->find($id);

            if (!$tarea) {
                return response()->json([
                    'error' => 'Tarea no encontrada'
                ], 404);
            }

            $validated = $request->validate([
                'nombre' => 'required|string|max:60',
                'descripcion' => 'nullable|string',
                'fecha_limite' => 'required|date',
                'urgencia' => 'required|integer|in:0,1,2',
                'finalizada' => 'sometimes|boolean'
            ]);

            $tarea->update($validated);

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

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Error al actualizar la tarea'
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage for API.
     */
    public function destroyApi($id) // CAMBIADO: De Tarea $tarea a $id
    {
        try {
            $tarea = Tarea::whereNull('deleted_at')->find($id);

            if (!$tarea) {
                return response()->json([
                    'error' => 'Tarea no encontrada'
                ], 404);
            }

            $tarea->delete();

            return response()->json([
                'message' => 'Tarea eliminada exitosamente'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Error al eliminar la tarea'
            ], 500);
        }
    }
}
