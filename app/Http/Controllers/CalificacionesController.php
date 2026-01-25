<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\alumno;
use App\Models\materia;
use App\Models\calificacion;
use Carbon\Carbon;

class CalificacionesController extends Controller
{
    /**
     * API 1: Resumen General y Lista de Materias
     * Ruta: GET /api/alumno/calificaciones/resumen
     */
    public function resumen(Request $request)
    {
        $user = $request->user();
        
        // 1. Obtener el alumno asociado al usuario logueado
        $alumno = Alumno::where('usuario_id', $user->id)->first();

        if (!$alumno) {
            return response()->json(['status' => 'error', 'message' => 'Alumno no encontrado'], 404);
        }

        // 2. Cargar materias inscritas con la información del docente y su usuario (para el nombre)
        $materias = $alumno->materias()->with(['docente.usuario'])->get();

        $materiasFormateadas = [];
        $sumaPromedios = 0;
        $materiasConNotas = 0;

        foreach ($materias as $materia) {
            // 3. Obtener calificaciones de esta materia para este alumno específico
            // Usamos el modelo Calificacion directamente ya que Materia no tiene la relación definida en tu código
            $calificaciones = Calificacion::where('materia_id', $materia->id)
                                ->where('alumno_id', $alumno->id)
                                ->get();

            $promedioMateria = $calificaciones->avg('nota');
            $promedioMateria = $promedioMateria ? round($promedioMateria, 1) : 0;

            if ($calificaciones->count() > 0) {
                $sumaPromedios += $promedioMateria;
                $materiasConNotas++;
            }

            // 4. Obtener nombre del profesor
            // docente -> usuario -> (nombre/name)
            // Asumo que tu tabla usuarios tiene 'name' o 'nombres', ajusta 'name' según tu tabla users.
            $nombreProfesor = 'Por asignar';
            if ($materia->docente && $materia->docente->usuario) {
                $nombreProfesor = $materia->docente->usuario->name ?? $materia->docente->usuario->nombres ?? 'Docente';
            }

            // 5. Estructura exacta para React Native
            $materiasFormateadas[] = [
                'id' => $materia->id,
                'name' => $materia->nombre, // Compatible con tu frontend
                'nombre' => $materia->nombre,
                'codigo' => $materia->codigo,
                'average' => (float) $promedioMateria,
                'color' => $materia->color_hex ?? '#2196F3',
                'icon' => $materia->icon ?? 'book',
                'profesor' => $nombreProfesor,
                'creditos' => $materia->creditos
            ];
        }

        // 6. Calcular promedio general
        $promedioGeneral = $materiasConNotas > 0 
            ? round($sumaPromedios / $materiasConNotas, 1) 
            : 0;

        return response()->json([
            'status' => 'success',
            'promedio_general' => (string) $promedioGeneral,
            'materias' => $materiasFormateadas
        ]);
    }

    /**
     * API 2: Detalle de calificaciones por materia
     * Ruta: GET /api/alumno/materias/{materia_id}/calificaciones
     */
    public function show(Request $request, $materia_id)
    {
        $user = $request->user();
        $alumno = Alumno::where('usuario_id', $user->id)->firstOrFail();

        // 1. Verificar que el alumno esté inscrito en esa materia
        $materia = $alumno->materias()->where('materias.id', $materia_id)->first();

        if (!$materia) {
            return response()->json([
                'status' => 'error', 
                'message' => 'No estás inscrito en esta materia'
            ], 403);
        }

        // 2. Obtener calificaciones detalladas
        $calificaciones = Calificacion::where('materia_id', $materia_id)
                            ->where('alumno_id', $alumno->id)
                            ->orderBy('fecha', 'desc')
                            ->get()
                            ->map(function ($cal) {
                                return [
                                    // Keys exactas que espera tu React Native (gradesData)
                                    'id' => $cal->id,
                                    'type' => $cal->tipo,       // Ej: "Parcial 1"
                                    'grade' => (float) $cal->nota,
                                    'date' => $cal->fecha ? Carbon::parse($cal->fecha)->format('d/m/Y') : 'Sin fecha',
                                    'weight' => 'N/A', // Tu modelo no tiene campo 'peso' o 'porcentaje', enviamos N/A
                                    'descripcion' => $cal->descripcion
                                ];
                            });

        // Calcular promedio actual
        $promedio = $calificaciones->avg('grade');

        return response()->json([
            'status' => 'success',
            'materia' => [
                'id' => $materia->id,
                'nombre' => $materia->nombre,
                'promedio_actual' => $promedio ? round($promedio, 1) : 0,
                'color' => $materia->color_hex,
                'icon' => $materia->icon
            ],
            'calificaciones' => $calificaciones
        ]);
    }
}