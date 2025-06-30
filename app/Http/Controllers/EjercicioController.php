<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEjercicioRequest;
use App\Models\Ejercicio;
use Illuminate\Http\Request;

class EjercicioController extends Controller
{
    public function index(){
        $ejercicios = Ejercicio::all();
        return response()->json($ejercicios);
    }

    public function store(StoreEjercicioRequest $request){
       $ejercicio = Ejercicio::create($request->validated());
        return response()->json($ejercicio,201);
    }

    public function update(){

    }
}
