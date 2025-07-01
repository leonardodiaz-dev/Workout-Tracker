<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoriaRequest;
use App\Models\Categoria;
use Illuminate\Http\Request;


class CategoriaController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/categorias",
     *     summary="Lista categorias",
     *     tags={"Categorias"},
     *     @OA\Response(
     *         response=200,
     *         description="Respuesta exitosa"
     *     )
     * )
     */
    public function index()
    {
        $categorias = Categoria::all();
        return response()->json($categorias);
    }
}
