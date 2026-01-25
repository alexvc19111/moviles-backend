<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Alumno;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class PerfilController extends Controller
{
    // 1. Obtener datos del perfil
    public function show(Request $request)
    {
        $user = $request->user();
        // Asumiendo relación: User hasOne Alumno
        $alumno = Alumno::where('usuario_id', $user->id)->firstOrFail();

        return response()->json([
            'status' => 'success',
            'alumno' => [
                'nombre' => $user->nombre, // O $alumno->nombres si está separado
                'email' => $user->correo,
                'matricula' => $alumno->codigo, // O matricula
                'carrera' => $alumno->carrera,
                'semestre' => $alumno->semestre,
                // Generar URL completa para la imagen
                'foto_url' => $user->foto_perfil 
                    ? asset('storage/' . $user->foto_perfil) 
                    : null // O una URL por defecto
            ]
        ]);
    }

    // 2. Actualizar SOLO la foto
    public function updatePhoto(Request $request)
    {
        $user = $request->user();

        // Validar que sea una imagen
        $validator = Validator::make($request->all(), [
            'foto' => 'required|image|mimes:jpeg,png,jpg|max:2048', // Max 2MB
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'errors' => $validator->errors()], 422);
        }

        if ($request->hasFile('foto')) {
            // 1. Borrar foto anterior si existe (opcional, para no llenar el server)
            if ($user->foto_perfil && Storage::disk('public')->exists($user->foto_perfil)) {
                Storage::disk('public')->delete($user->foto_perfil);
            }

            // 2. Guardar nueva foto en carpeta 'perfiles' dentro de 'public'
            $path = $request->file('foto')->store('perfiles', 'public');

            // 3. Actualizar base de datos
            $user->foto_perfil = $path;
            $user->save();

            return response()->json([
                'status' => 'success',
                'message' => 'Foto actualizada correctamente',
                'foto_url' => asset('storage/' . $path)
            ]);
        }

        return response()->json(['status' => 'error', 'message' => 'No se subió ninguna imagen'], 400);
    }
}