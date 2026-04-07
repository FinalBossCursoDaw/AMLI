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

        // 2. Intentar hacer login
        $credentials = [
            'correu' => $request->correu,
            'password' => $request->contrasenya,  // Laravel busca 'password' internamente
        ];

        if (Auth::attempt($credentials)) {
            // 3. Login exitoso → redirigir al dashboard
            return redirect()->intended('/dashboard');
        }

        // 4. Login fallido → volver con error
        return back()->withErrors([
            'correu' => 'Credenciales incorrectas.',
        ]);
    }

    // Cerrar sesión
    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
}