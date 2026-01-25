<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Alumno;
use App\Models\Materia;

class HorarioController extends Controller
{
    /**
     * Retorna todos los horarios del alumno logueado, ordenados por día y hora.
     * Compatible con PostgreSQL.
     *
     * GET /alumno/horarios
     */
    public function todos(Request $request)
    {
        $usuario = $request->user();
        $alumno = Alumno::where('usuario_id', $usuario->id)->firstOrFail();

        // 1. Obtener materias con sus horarios.
        // Quitamos el FIELD() y solo ordenamos por hora en la BD.
        // El orden de los días lo manejaremos al construir el array JSON.
        $materias = $alumno->materias()->with(['horarios' => function($q) {
            $q->orderBy('hora_inicio', 'asc');
        }])->get();

        // 2. Inicializar el array en el orden exacto que queremos que aparezcan los días.
        // Esto garantiza el orden "Lunes, Martes..." sin usar SQL.
        $horariosPorDia = [
            'Lunes'     => [],
            'Martes'    => [],
            'Miércoles' => [],
            'Jueves'    => [],
            'Viernes'   => [],
            'Sábado'    => [],
            'Domingo'   => []
        ];

        // 3. Llenar los datos
        foreach ($materias as $materia) {
            foreach ($materia->horarios as $h) {
                // Verificar si el día existe en nuestro array (por seguridad)
                if (array_key_exists($h->dia, $horariosPorDia)) {
                    $horariosPorDia[$h->dia][] = [
                        'materia_id'  => $materia->id,
                        'materia'     => $materia->nombre,
                        'profesor'    => $h->profesor,
                        'aula'        => $h->aula,
                        'hora_inicio' => $h->hora_inicio,
                        'hora_fin'    => $h->hora_fin,
                        'color'       => $materia->color_hex,
                        'icon'        => $materia->icon,
                    ];
                }
            }
        }

        // 4. (Opcional pero recomendado) Reordenar cada día por hora de inicio.
        // Como iteramos materias y no horarios directamente, podría haber desorden
        // si tienes Matemáticas a las 10am y luego Historia a las 8am procesadas en ese orden.
        foreach ($horariosPorDia as $dia => &$clases) {
            usort($clases, function ($a, $b) {
                return strcmp($a['hora_inicio'], $b['hora_inicio']);
            });
        }

        return response()->json([
            'status' => 'success',
            'horarios' => $horariosPorDia
        ]);
    }

    /**
     * Retorna los horarios de una materia específica.
     * Compatible con PostgreSQL.
     *
     * GET /alumno/materias/{materia_id}/horarios
     */
    public function materiaEspecifica(Request $request, $materia_id)
    {
        $usuario = $request->user();
        $alumno = Alumno::where('usuario_id', $usuario->id)->firstOrFail();

        // 1. Obtener la materia y sus horarios ordenados solo por hora
        $materia = $alumno->materias()
            ->where('materias.id', $materia_id)
            ->with(['horarios' => function($q) {
                $q->orderBy('hora_inicio', 'asc');
            }])
            ->first();

        if (!$materia) {
            return response()->json(['status' => 'error', 'message' => 'No inscrito o materia no encontrada.'], 404);
        }

        // 2. Definir peso de días para ordenamiento (Lógica PHP en lugar de SQL FIELD)
        $ordenDias = [
            'Lunes' => 1, 'Martes' => 2, 'Miércoles' => 3, 'Jueves' => 4,
            'Viernes' => 5, 'Sábado' => 6, 'Domingo' => 7
        ];

        // 3. Ordenar la colección usando Laravel Collections (sortBy)
        $horariosOrdenados = $materia->horarios->sortBy(function($horario) use ($ordenDias) {
            // Ordenar primero por día (usando el peso), luego por hora (que ya viene de BD, pero aseguramos)
            return ($ordenDias[$horario->dia] ?? 8) . $horario->hora_inicio;
        });

        // 4. Inicializar estructura
        $horariosPorDia = [
            'Lunes' => [], 'Martes' => [], 'Miércoles' => [], 'Jueves' => [],
            'Viernes' => [], 'Sábado' => [], 'Domingo' => []
        ];

        // 5. Agrupar datos
        foreach ($horariosOrdenados as $h) {
            if (array_key_exists($h->dia, $horariosPorDia)) {
                $horariosPorDia[$h->dia][] = [
                    'materia_id'  => $materia->id,
                    'materia'     => $materia->nombre,
                    'profesor'    => $h->profesor,
                    'aula'        => $h->aula,
                    'hora_inicio' => $h->hora_inicio,
                    'hora_fin'    => $h->hora_fin,
                    'color'       => $materia->color_hex,
                    'icon'        => $materia->icon,
                ];
            }
        }

        return response()->json([
            'status' => 'success',
            'materia' => [
                'id' => $materia->id,
                'nombre' => $materia->nombre,
                'color' => $materia->color_hex,
                'icon' => $materia->icon
            ],
            'horarios' => $horariosPorDia
        ]);
    }
}