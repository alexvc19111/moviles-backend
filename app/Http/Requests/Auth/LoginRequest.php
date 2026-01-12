<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'correo' => [
                'required',
                'email',
                // Validación para alumnos (e + 10 digitos) o docentes (texto.texto)
                'regex:/^(e\d{10}@live\.uleam\.edu\.ec|[a-z]+\.[a-z]+@uleam\.edu\.ec)$/'
            ],
            'contraseña' => 'required'
        ];
    }

    public function messages()
    {
        return [
            // Validación de CORREO
            'correo.required' => 'El correo electrónico es obligatorio.',
            'correo.email'    => 'Debes ingresar una dirección de correo válida.',
            'correo.regex'    => 'El correo debe ser institucional ULEAM (@uleam.edu.ec).',

            // Validación de CONTRASEÑA
            'contraseña.required' => 'La contraseña es obligatoria.'
        ];
    }
}