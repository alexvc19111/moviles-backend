<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class inscripcion extends Model
{
    protected $table = 'inscripciones';

    protected $fillable = [
        'alumno_id',
        'materia_id',
        'fecha_matricula',
    ];

    public function alumno()
    {
        return $this->belongsTo(alumno::class, 'alumno_id');
    }

    public function materia()
    {
        return $this->belongsTo(materia::class, 'materia_id');
    }
}
