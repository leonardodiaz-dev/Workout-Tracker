<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEntrenamientoRequest;
use App\Http\Requests\UpdateEntrenamientoRequest;
use App\Http\Resources\EntrenamientoResource;
use App\Models\Entrenamiento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EntrenamientoController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/v1/entrenamientos",
     *     summary="Listar entrenamientos del usuario autenticado",
     *     tags={"Entrenamientos"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="status",
     *         in="query",
     *         description="Filtrar por estado",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Listado de entrenamientos"
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="No autorizado"
     *     )
     * )
     */
    public function index(Request $request)
    {
        $query = Entrenamiento::query();

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        $entrenamientos = $query->with('ejercicios')
            ->where('user_id', Auth::id())
            ->orderBy('fecha_programacion', 'desc')
            ->get();

        return EntrenamientoResource::collection($entrenamientos);
    }
    /**
     * @OA\Get(
     *     path="/api/v1/entrenamientos/{id}",
     *     summary="Ver un entrenamiento por ID",
     *     tags={"Entrenamientos"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID del entrenamiento",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Detalles del entrenamiento"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Entrenamiento no encontrado"
     *     )
     * )
     */
    public function show($id)
    {
        $entrenamiento = Entrenamiento::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        return response()->json($entrenamiento);
    }
    /**
     * @OA\Post(
     *     path="/api/v1/entrenamientos",
     *     summary="Crear un nuevo entrenamiento",
     *     tags={"Entrenamientos"},
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"titulo", "ejercicios"},
     *             @OA\Property(property="titulo", type="string"),
     *             @OA\Property(property="comentario", type="string", nullable=true),
     *             @OA\Property(property="fecha_programacion", type="string", format="date", nullable=true),
     *             @OA\Property(
     *                 property="ejercicios",
     *                 type="array",
     *                 @OA\Items(
     *                     @OA\Property(property="id", type="integer"),
     *                     @OA\Property(property="series", type="integer"),
     *                     @OA\Property(property="repeticiones", type="integer"),
     *                     @OA\Property(property="peso", type="number", format="float", nullable=true)
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Entrenamiento creado correctamente"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Datos inválidos"
     *     )
     * )
     */
    public function store(StoreEntrenamientoRequest $request)
    {
        $entrenamiento = Entrenamiento::create([
            'titulo' => $request->titulo,
            'comentario' => $request->comentario ?? null,
            'fecha_programacion' => $request->fecha_programacion ?? null,
            'user_id' => Auth::id(),
        ]);
        $attachData = [];

        foreach ($request['ejercicios'] as $ejercicio) {
            $attachData[$ejercicio['id']] = [
                'series' => $ejercicio['series'],
                'repeticiones' => $ejercicio['repeticiones'],
                'peso' => $ejercicio['peso'] ?? null,
            ];
        }
        $entrenamiento->ejercicios()->attach($attachData);
        return response()->json($entrenamiento);
    }
    /**
     * @OA\Put(
     *     path="/api/v1/entrenamientos/{id}",
     *     summary="Actualizar un entrenamiento",
     *     tags={"Entrenamientos"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID del entrenamiento",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"titulo", "ejercicios"},
     *             @OA\Property(property="titulo", type="string"),
     *             @OA\Property(property="comentario", type="string", nullable=true),
     *             @OA\Property(property="fecha_programacion", type="string", format="date", nullable=true),
     *             @OA\Property(
     *                 property="ejercicios",
     *                 type="array",
     *                 @OA\Items(
     *                     @OA\Property(property="id", type="integer"),
     *                     @OA\Property(property="series", type="integer"),
     *                     @OA\Property(property="repeticiones", type="integer"),
     *                     @OA\Property(property="peso", type="number", format="float", nullable=true)
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Entrenamiento actualizado"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Entrenamiento no encontrado"
     *     )
     * )
     */
    public function update(UpdateEntrenamientoRequest $request, $id)
    {
        $entrenamiento = Entrenamiento::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();
        $entrenamiento->update($request->all());
        $syncData = [];
        foreach ($request['ejercicios'] as $ejercicio) {
            $syncData[$ejercicio['id']] = [
                'series' => $ejercicio['series'],
                'repeticiones' => $ejercicio['repeticiones'],
                'peso' => $ejercicio['peso'],
            ];
        }
        $entrenamiento->ejercicios()->sync($syncData);
        return response()->json($entrenamiento);
    }
    /**
     * @OA\Delete(
     *     path="/api/v1/entrenamientos/{id}",
     *     summary="Eliminar un entrenamiento",
     *     tags={"Entrenamientos"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID del entrenamiento",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Entrenamiento eliminado con éxito"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Entrenamiento no encontrado"
     *     )
     * )
     */
    public function destroy($id)
    {
        $entrenamiento = Entrenamiento::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();
        $entrenamiento->delete();
        return response()->json(['message' => 'Entrenamiento eliminado con exito']);
    }
}
