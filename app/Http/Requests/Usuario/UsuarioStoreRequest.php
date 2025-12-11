<?php

namespace App\Http\Requests\Usuario;

use Illuminate\Foundation\Http\FormRequest;

class UsuarioStoreRequest extends FormRequest
{
    public function rules()
    {
        return [
            'nombre'   => 'required|string',
            'apellido' => 'required|string',
            'email'    => 'required|email|unique:usuarios,email',
            'password' => 'required|min:6',
            'rol'      => 'required|in:admin,docente,alumno'
        ];
    }
}
