<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckRole
{

    public function handle(Request $request, Closure $next, ...$roles)
    {
        $usuario = $request->user();

        if (!$usuario) {
            return response()->json(['error' => 'No autenticado'], 401);
        }

        if (!in_array($usuario->rol, $roles)) {
            return response()->json(['error' => 'Acceso no autorizado'], 403);
        }

        return $next($request);
    }
}
