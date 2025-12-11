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
                'regex:/^(e\d{9}@live\.uleam\.edu\.ec|[a-z]+\.[a-z]+@uleam\.edu\.ec)$/'
            ],
            'contraseña' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'email.regex' => 'El correo debe ser institucional ULEAM.'
        ];
    }
}
