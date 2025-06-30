<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoriaRequest;
use App\Models\Categoria;
use Illuminate\Http\Request;

class CategoriaController extends Controller
{
    public function index(){
        $categorias = Categoria::all();
        return response()->json($categorias);
    }
    public function store(StoreCategoriaRequest $request){
        $categoria = Categoria::create($request->all());
        return response()->json($categoria,200);
    }
    public function update(){
        
    }
}
