<?php

namespace App\Http\Requests\Usuario;

use Illuminate\Foundation\Http\FormRequest;

class UsuarioUpdateRequest extends FormRequest
{
    public function rules()
    {
        return [
            'nombre'   => 'sometimes|string',
            'apellido' => 'sometimes|string',
            'email'    => 'sometimes|email|unique:usuarios,email,' . $this->id,
            'password' => 'nullable|min:6',
            'rol'      => 'sometimes|in:admin,docente,alumno'
        ];
    }
}
