<?php

namespace App\Http\Controllers;

use App\Models\GrupoMuscular;
use Illuminate\Http\Request;

class GrupoMuscularController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/gruposMusculares",
     *     summary="Lista grupos musculares",
     *     tags={"Grupos musculares"},
     *     @OA\Response(
     *         response=200,
     *         description="Respuesta exitosa"
     *     )
     * )
     */
    public function index()
    {
        $grupos_musculares = GrupoMuscular::all();
        return response()->json($grupos_musculares);
    }
}
