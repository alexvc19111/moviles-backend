<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class asistencia extends Model
{
    protected $table = 'asistencias';

    protected $fillable = [
        'alumno_id',
        'materia_id',
        'faltas',
        'justificadas',
        'total_clases'
    ];

    // Relación con el alumno
    public function alumno()
    {
        return $this->belongsTo(alumno::class, 'alumno_id');
    }

    // Relación con la materia
    public function materia()
    {
        return $this->belongsTo(materia::class, 'materia_id');
    }
}
