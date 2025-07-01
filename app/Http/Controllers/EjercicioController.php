<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEjercicioRequest;
use App\Models\Ejercicio;
use Illuminate\Http\Request;

class EjercicioController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/ejercicios",
     *     summary="Lista ejercicios",
     *     tags={"Ejercicios"},
     *     @OA\Response(
     *         response=200,
     *         description="Respuesta exitosa"
     *     )
     * )
     */
    public function index()
    {
        $ejercicios = Ejercicio::all();
        return response()->json($ejercicios);
    }
    /**
     * @OA\Post(
     *     path="/api/ejercicios",
     *     summary="Crear ejercicio",
     *     tags={"Ejercicios"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"nombre", "descripcion","categoria_id","grupo_muscular_id"},
     *             @OA\Property(property="nombre", type="string"),
     *             @OA\Property(property="descripcion", type="string"),
     *             @OA\Property(property="categoria_id", type="integer"),
     *             @OA\Property(property="grupo_muscular_id", type="integer"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Respuesta exitosa"
     *     )
     * )
     */
    public function store(StoreEjercicioRequest $request)
    {
        $ejercicio = Ejercicio::create($request->validated());
        return response()->json($ejercicio, 201);
    }

    public function update() {}
}
