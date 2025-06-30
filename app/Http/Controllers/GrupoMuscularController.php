<?php

namespace App\Http\Controllers;

use App\Models\GrupoMuscular;
use Illuminate\Http\Request;

class GrupoMuscularController extends Controller
{
    public function index(){
        $grupos_musculares = GrupoMuscular::all();
        return response()->json($grupos_musculares);
    }
}
