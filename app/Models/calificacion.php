<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class calificacion extends Model
{
    protected $table = 'calificaciones';

    protected $fillable = [
        'alumno_id',
        'materia_id',
        'tipo',
        'nota',
        'descripcion',
        'fecha',
        'creado_por'
    ];

    public function alumno()
    {
        return $this->belongsTo(usuario::class, 'alumno_id');
    }

    public function materia()
    {
        return $this->belongsTo(materia::class, 'materia_id');
    }

    public function creador()
    {
        return $this->belongsTo(usuario::class, 'creado_por');
    }
}
