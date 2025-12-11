<?php

namespace App\Services;

use App\Repositories\AuthRepository;
use Illuminate\Support\Facades\Hash;
use App\Models\usuario;

class AuthService
{
    protected $authRepository;

    public function __construct(AuthRepository $authRepository)
    {
        $this->authRepository = $authRepository;
    }

    public function register(array $data)
    {
        $rol = $this->getRolPorCorreo($data['correo']);
        $data['contraseña'] = Hash::make($data['contraseña']);
        return $this->authRepository->createUser($data , $rol);
    }

    public function login(array $data)
{
    $user = usuario::where('correo', $data['correo'])->first();

    if (!$user || !\Hash::check($data['contraseña'], $user->contraseña)) {
        return null;
    }

    return $user->createToken('api_token')->plainTextToken;
}

    private function getRolPorCorreo($correo)
    {
        if (preg_match('/^e\d{9}@live\.uleam\.edu\.ec$/', $correo)) {
            return 'alumno'; 
        }

        if (preg_match('/^[a-z]+\.[a-z]+@uleam\.edu\.ec$/', $correo)) {
            return 'docente'; 
        }

        return null;
    }
}
