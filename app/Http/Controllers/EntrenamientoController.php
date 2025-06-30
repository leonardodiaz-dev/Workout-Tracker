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

    public function show($id)
    {
        $entrenamiento = Entrenamiento::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        return response()->json($entrenamiento);
    }


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
    public function destroy($id)
    {
        $entrenamiento = Entrenamiento::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();
        $entrenamiento->delete();
        return response()->json(['message' => 'Entrenamiento eliminado con exito']);
    }
}
