<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class horario extends Model
{
    protected $fillable = [
        'materia_id',
        'dia',
        'hora_inicio',
        'hora_fin',
        'aula',
        'profesor',
    ];

    public function materia()
    {
        return $this->belongsTo(materia::class);
    }
}
