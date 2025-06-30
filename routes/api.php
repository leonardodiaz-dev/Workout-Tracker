<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\EjercicioController;
use App\Http\Controllers\EntrenamientoController;
use App\Http\Controllers\GrupoMuscularController;
use App\Http\Controllers\InformeController;
use App\Http\Middleware\IsUserAuth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
Route::apiResource("categorias", CategoriaController::class);
Route::apiResource("gruposMusculares", GrupoMuscularController::class);
Route::apiResource("ejercicios", EjercicioController::class);

Route::middleware([IsUserAuth::class])->group(function () {
    Route::prefix('v1')->group(function () {
        Route::get('informes', [InformeController::class, 'resumen']);
        Route::apiResource("entrenamientos", EntrenamientoController::class);
    });
});
