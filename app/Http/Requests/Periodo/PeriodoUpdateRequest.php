<?php

namespace App\Http\Requests\Periodo;

use Illuminate\Foundation\Http\FormRequest;

class PeriodoUpdateRequest extends FormRequest
{
    public function rules()
    {
        return [
            'nombre'      => 'sometimes|string|max:100',
            'fecha_inicio'  => 'sometimes|date|unique:periodos_academicos,fecha_inicio',
            'fecha_fin' => 'sometimes|date|after:fecha_inicio'
        ];
    }
}
