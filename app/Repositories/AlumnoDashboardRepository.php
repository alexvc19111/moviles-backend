<?php
namespace App\Repositories;

use App\Models\asistencia;
use App\Models\calificacion;
use App\Models\aviso;
use App\Models\horario;
use App\Models\materia;

class AlumnoDashboardRepository
{
    public function getMaterias($alumnoId)
    {
        return materia::whereHas('alumnos', function($q) use ($alumnoId) {
            $q->where('alumno_id', $alumnoId);
        })
        // 👇 CAMBIO 1: Agregamos 'docente.usuario' para traer el nombre del profesor
        ->with(['periodo', 'docente.usuario']) 
        ->get();
    }

    public function getPromedio($alumnoId)
    {
        return calificacion::where('alumno_id', $alumnoId)->avg('nota') ?? 0;
    }

    public function getAsistencia($alumnoId)
    {
        return asistencia::where('alumno_id', $alumnoId)
            ->selectRaw('
                CASE 
                  WHEN SUM(total_clases) = 0 THEN 0
                  ELSE 100 - ((SUM(faltas)::float / SUM(total_clases)) * 100)
                END as porcentaje
            ')->value('porcentaje');
    }

    public function getUltimasNotas($alumnoId)
    {
        return calificacion::where('alumno_id', $alumnoId)
            ->with('materia.periodo')
            ->latest()
            ->limit(5)
            ->get();
    }

    public function getAvisos()
    {
        return aviso::latest()->limit(5)->get();
    }

    public function getProximasClases($alumnoId)
    {
        return horario::whereHas('materia.alumnos', function($q) use ($alumnoId) {
            $q->where('alumno_id', $alumnoId);
        })
        // 👇 CAMBIO 2: Agregamos 'materia.docente.usuario'
        // Esto permite acceder a: horario -> materia -> docente -> usuario -> nombre
        ->with(['materia.periodo', 'materia.docente.usuario']) 
        ->orderBy('hora_inicio')
        ->limit(5)
        ->get();
    }
}