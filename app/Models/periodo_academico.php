<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class periodo_academico extends Model
{
    protected $table = 'periodos_academicos';

    protected $fillable = [
        'nombre',
        'fecha_inicio',
        'fecha_fin'
    ];

    public function materias()
    {
        return $this->hasMany(materia::class, 'periodo_id');
    }
}
