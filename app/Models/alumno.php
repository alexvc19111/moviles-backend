<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class alumno extends Model
{
    protected $fillable = [
        'usuario_id', 'codigo', 'carrera', 'semestre'
    ];

    public function usuario()
    {
        return $this->belongsTo(usuario::class);
    }

    public function materias()
{
    return $this->belongsToMany(
        materia::class,
        'inscripciones',
        'alumno_id',   // columna de la tabla pivote que apunta a alumno
        'materia_id'   // columna de la tabla pivote que apunta a materia
    )->withTimestamps()
     ->withPivot('fecha_inscripcion');
}

    public function calificaciones()
    {
        return $this->hasMany(calificacion::class);
    }

    public function asistencias()
    {
        return $this->hasMany(asistencia::class);
    }

    public function inscripciones()
    {
        return $this->hasMany(inscripcion::class);
    }
}

