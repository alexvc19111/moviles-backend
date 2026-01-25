<?php
namespace App\Services;
use App\Repositories\AlumnoDashboardRepository;

class AlumnoDashboardService
{
    public function __construct(
        protected AlumnoDashboardRepository $repo
    ) {}

    public function getDashboard($alumnoId)
    {
        return [
            'promedio' => round($this->repo->getPromedio($alumnoId), 2),
            'asistencias' => round($this->repo->getAsistencia($alumnoId), 0),
            'materias' => $this->repo->getMaterias($alumnoId),
            'calificaciones' => $this->repo->getUltimasNotas($alumnoId),
            'avisos' => $this->repo->getAvisos(),
            'proximasClases' => $this->repo->getProximasClases($alumnoId)
        ];
    }
}
