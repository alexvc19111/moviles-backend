<?php

namespace App\Http\Requests\Materia;

use Illuminate\Foundation\Http\FormRequest;

class MateriaStoreRequest extends FormRequest
{
    public function rules()
    {
        return [
            'nombre'      => 'required|string|max:100',
            'codigo'      => 'required|string|max:50|unique:materias,codigo',
            'descripcion' => 'nullable|string',
            'docente_id'  => 'required|exists:usuarios,id',
            'periodo_id'  => 'required|exists:periodos_academicos,id'
        ];
    }
}
