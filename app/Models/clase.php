<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class clase extends Model
{
    protected $table = 'clases';

    protected $fillable = [
        'materia_id',
        'fecha',
        'hora_inicio',
        'hora_fin',
        'tema'
    ];

    public function materia()
    {
        return $this->belongsTo(materia::class, 'materia_id');
    }

    public function asistencias()
    {
        return $this->hasMany(asistencia::class, 'clase_id');
    }
}
