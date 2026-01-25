<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\MateriaController;
use App\Http\Controllers\PeriodoController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HorarioController;
use App\Http\Controllers\CalificacionesController;
use App\Http\Controllers\PerfilController;
use App\Http\Controllers\AsistenciaController;

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


Route::middleware(['auth:sanctum', 'rol:alumno'])->group(function () {
    Route::get('/alumno/dashboard', [DashboardController::class, 'index']);
Route::get('/alumno/materias', fn() => auth()->user()->alumno->materias()
    ->with(['periodo', 'docente.usuario']) // <--- AGREGADO: 'docente.usuario'
    ->get()
);    Route::get('/alumno/calificaciones', fn() => auth()->user()->alumno->calificaciones()->with('materia.periodo')->get());
    Route::get('/alumno/horarios', [HorarioController::class, 'todos']);
    Route::get('/alumno/materias/{materia_id}/horarios', [HorarioController::class, 'materiaEspecifica']);
    Route::get('/alumno/calificaciones/resumen', [CalificacionesController::class, 'resumen']);
    Route::get('/alumno/materias/{id}/calificaciones', [CalificacionesController::class, 'show']);
    Route::get('/alumno/perfil', [PerfilController::class, 'show']);
    Route::post('/alumno/perfil/foto', [PerfilController::class, 'updatePhoto']);
    Route::get('/alumno/asistencias', [AsistenciaController::class, 'index']);
});



