<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\asistencia;
use App\Models\alumno;

class AsistenciaController extends Controller
{
    public function index(Request $request)
    {
        $usuario = $request->user();
        $perfilAlumno = $usuario->alumno;

        if (!$perfilAlumno) {
            return response()->json(['status' => 'error', 'message' => 'Sin perfil de alumno'], 404);
        }

        // 1. CAMBIO AQUÍ: Cargamos materia -> docente -> usuario
        $registros = asistencia::with(['materia.docente.usuario']) 
                        ->where('alumno_id', $perfilAlumno->id)
                        ->get();

        // ... (Cálculos del resumen igual que antes) ...
        $sumTotalClases = $registros->sum('total_clases');
        $sumFaltas = $registros->sum('faltas');
        $sumAsistencias = $sumTotalClases - $sumFaltas; 
        $promedioGeneral = $sumTotalClases > 0 ? round(($sumAsistencias / $sumTotalClases) * 100) : 0;

        $materiasData = $registros->map(function ($registro) {
            $materia = $registro->materia;
            
            // Cálculos
            $total = $registro->total_clases;
            $faltas = $registro->faltas;
            $asistencias = $total - $faltas;
            $porcentaje = $total > 0 ? ($asistencias / $total) * 100 : 0;

            // Estado
            $estado = 'Regular';
            if ($porcentaje == 100) $estado = 'Perfecto';
            elseif ($porcentaje >= 90) $estado = 'Excelente';
            elseif ($porcentaje >= 80) $estado = 'Bueno';
            elseif ($porcentaje < 70) $estado = 'Peligro';

            // Color
            $colores = ['#FF6B6B', '#4ECDC4', '#45B7D1', '#96CEB4', '#FFD93D'];
            $color = isset($materia->id) ? $colores[$materia->id % count($colores)] : '#2196F3';

            // 2. CAMBIO AQUÍ: ACCEDER AL USUARIO DENTRO DEL DOCENTE
            $nombreProfesor = 'Sin asignar';
            
            // Verificamos la cadena completa: Materia -> Docente -> Usuario
            if ($materia && $materia->docente && $materia->docente->usuario) {
                $nombreProfesor = $materia->docente->usuario->nombre; 
            }

            return [
                'id' => $materia->id ?? 0,
                'nombre' => $materia->nombre ?? 'Desconocida',
                'profesor' => $nombreProfesor, // Ahora sí saldrá el nombre
                'color' => $color,
                'total_clases' => $total,
                'asistencias' => $asistencias,
                'faltas' => $faltas,
                'retardos' => 0,
                'estado' => $estado
            ];
        });

        return response()->json([
            'status' => 'success',
            'data' => [
                'resumen' => [
                    'promedioAsistencia' => $promedioGeneral,
                    'totalClases' => $sumTotalClases,
                    'asistencias' => $sumAsistencias,
                    'faltas' => $sumFaltas,
                    'retardos' => 0,
                ],
                'materias' => $materiasData,
                'historial' => []
            ]
        ]);
    }
}