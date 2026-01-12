<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\MateriaController;
use App\Http\Controllers\PeriodoController;
use App\Http\Controllers\AuthController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Ruta de prueba para verificar conexión
Route::get('/prueba', function () {
    return response()->json([
        'mensaje' => '¡Conexión exitosa con Laravel!',
        'status' => 'OK'
    ]);
});

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
Route::get('/me', [AuthController::class, 'me'])->middleware('auth:sanctum');
Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('usuarios', UsuarioController::class);
    Route::middleware(['auth:sanctum', 'rol:profesor'])->group(function () {
        Route::apiResource('materias', MateriaController::class);
    });
    Route::apiResource('periodos', PeriodoController::class);
});



