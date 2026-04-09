<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    // Mostrar la página de login
    public function show()
    {
        return view('Register');  // Tu vista actual
    }

    // Procesar el login
    public function login(Request $request)
    {
        // 1. Validar que lleguen los campos
        $request->validate([
            'correu' => 'required|email',
            'contrasenya' => 'required',
        ]);

        // 2. Buscar el usuario manualmente para debug
        $user = \App\Models\Usuari::where('correu', $request->correu)->first();
        
        if (!$user) {
            return response()->json([
                'errors' => ['correu' => ['Usuario no encontrado.']]
            ], 422);
        }

        // 3. Verificar contraseña manualmente
        if (!\Illuminate\Support\Facades\Hash::check($request->contrasenya, $user->contrasenya)) {
            return response()->json([
                'errors' => ['correu' => ['Contraseña incorrecta.']]
            ], 422);
        }

        // 4. Login manual
        Auth::login($user);

        return response()->json(['success' => true]);
    }

    // Cerrar sesión
    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
}