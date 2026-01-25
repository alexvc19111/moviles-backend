<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Requests\Auth\LoginRequest;
use App\Services\AuthService;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }


    public function register(RegisterRequest $request)
    {
        $usuario = $this->authService->register($request->validated());
        
        return response()->json([
            'message' => 'Usuario registrado exitosamente',
            'usuario' => $usuario
        ], 201);
        event(new UsuarioRegistrado($usuario));

    }


    public function login(LoginRequest $request)
    {
        $token = $this->authService->login($request->validated());

        if (!$token) {
            return response()->json([
                'error' => 'Credenciales inválidas'
            ], 401);
        }

        return response()->json([
            'message' => 'Inicio de sesión exitoso',
            'token' => $token
        ]);
    }


    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Sesión cerrada correctamente'
        ]);
    }


    public function me(Request $request)
    {
        return response()->json([
            'usuario' => $request->user()
        ]);
    }
}
