<?php

namespace App\Http\Requests\Periodo;

use Illuminate\Foundation\Http\FormRequest;

class PeriodoStoreRequest extends FormRequest
{
    public function rules()
    {
        return [
            'nombre'      => 'required|string|max:100',
            'fecha_inicio'  => 'required|date|unique:periodos_academicos,fecha_inicio',
            'fecha_fin' => 'required|date|after:fecha_inicio'
        ];
    }
}
