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
        try {
            $request->validate([
                'correu' => 'required|email',
                'contrasenya' => 'required',
            ]);

            $user = \App\Models\Usuari::where('correu', $request->correu)->first();

            if (!$user) {
                return response()->json([
                    'errors' => ['correu' => ['Usuario no encontrado.']],
                ], 422);
            }

            if ($request->contrasenya !== $user->contrasenya) {
                return response()->json([
                    'errors' => ['correu' => ['Contrasena incorrecta.']],
                ], 422);
            }

            Auth::login($user);

            if ($user->rol_id == 1) {
                $redirect = '/dashboard-admin';
            } else {
                $redirect = '/dashboard-operador-cliente';
            }

            return response()->json([
                'success' => true,
                'redirect' => $redirect,
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'error' => 'Error en el servidor: ' . $e->getMessage()
            ], 500);
        }
    }

    // Cerrar sesión
    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
}
