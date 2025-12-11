<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class materia extends Model
{
    protected $table = 'materias';

    protected $fillable = [
        'nombre',
        'codigo',
        'descripcion',
        'docente_id',
        'periodo_id'
    ];

    public function docente()
    {
        return $this->belongsTo(usuario::class, 'docente_id');
    }

    public function periodo()
    {
        return $this->belongsTo(periodo_academico::class, 'periodo_id');
    }

    public function inscripciones()
    {
        return $this->hasMany(inscripcion::class, 'materia_id');
    }

    public function alumnos()
    {
        return $this->belongsToMany(usuario::class, 'inscripciones', 'materia_id', 'alumno_id');
    }

    public function clases()
    {
        return $this->hasMany(clase::class, 'materia_id');
    }

    public function calificaciones()
    {
        return $this->hasMany(calificacion::class, 'materia_id');
    }
}
