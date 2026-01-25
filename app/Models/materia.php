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
        'creditos',
        'color_hex',
        'icon',
        'docente_id',
        'periodo_academico_id'
    ];

    public function periodo()
    {
        return $this->belongsTo(periodo_academico::class, 'periodo_academico_id');
    }

    public function docente()
    {
        return $this->belongsTo(docente::class, 'docente_id');
    }

    public function alumnos()
    {
        return $this->belongsToMany(alumno::class, 'inscripciones')
            ->withTimestamps()
            ->withPivot('fecha_inscripcion');
    }
    public function horarios()
{
    return $this->hasMany(horario::class, 'materia_id');
}

}
