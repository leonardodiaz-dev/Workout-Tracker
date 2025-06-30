<?php

namespace App\Http\Controllers;

use App\Models\Entrenamiento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InformeController extends Controller
{
    public function resumen(Request $request)
    {
        $userId = Auth::id();

        $entrenamientosPasados = Entrenamiento::where('user_id', $userId)
            ->where('fecha_programacion', '<=', now())
            ->with('ejercicios')
            ->get();

        $totalEntrenamientos = $entrenamientosPasados->count();
        $totalSeries = 0;
        $totalRepeticiones = 0;
        $totalPeso = 0;

        foreach ($entrenamientosPasados as $entrenamiento) {
            foreach ($entrenamiento->ejercicios as $ejercicio) {
                $detalle = $ejercicio->detalle;
                $totalSeries += $detalle->series;
                $totalRepeticiones += $detalle->series * $detalle->repeticiones;
                $totalPeso += $detalle->series * $detalle->repeticiones * $detalle->peso;
            }
        }

        return response()->json([
            'total_entrenamientos' => $totalEntrenamientos,
            'series_totales' => $totalSeries,
            'repeticiones_totales' => $totalRepeticiones,
            'peso_total_levantado_kg' => round($totalPeso, 2),
        ]);
    }
}
