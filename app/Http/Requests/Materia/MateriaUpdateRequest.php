<?php

namespace App\Http\Requests\Materia;

use Illuminate\Foundation\Http\FormRequest;

class MateriaUpdateRequest extends FormRequest
{
    public function rules()
    {
        return [
            'nombre'      => 'sometimes|string|max:100',
            'codigo'      => 'sometimes|string|max:50|unique:materias,codigo,' . $this->id,
            'descripcion' => 'sometimes|string',
            'docente_id'  => 'sometimes|exists:usuarios,id',
            'periodo_id'  => 'sometimes|exists:periodos_academicos,id'
        ];
    }
}
