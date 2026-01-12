<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'nombre' => 'required|string|max:150',
            'correo' => [
                'required',
                'email',
                'unique:usuarios,correo',
                'regex:/^(e\d{10}@live\.uleam\.edu\.ec|[a-z]+\.[a-z]+@uleam\.edu\.ec)$/'
            ],
            'contraseña' => 'required|min:6',
        ];
    }

    public function messages()
    {
        return [
            'email.regex' => 'Solo se permiten correos institucionales ULEAM: estudiantes (e#########@live.uleam.edu.ec) o docentes (nombre.apellido@uleam.edu.ec).'
        ];
    }
}
