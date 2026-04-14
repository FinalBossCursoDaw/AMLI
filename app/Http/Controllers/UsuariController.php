<?php

namespace App\Http\Controllers;

use App\Models\Usuari;
use Illuminate\Http\Request;

class UsuariController extends Controller
{
    public function index()
    {
        $usuaris = Usuari::select(
            'id',
            'nom',
            'cognoms',
            'correu',
            'username',
            'rol_id'
        )
            ->orderBy('nom')
            ->orderBy('cognoms')
            ->get()
            ->map(function ($usuari) {
                return [
                    'id' => $usuari->id,
                    'nom_complet' => trim($usuari->nom . ' ' . $usuari->cognoms),
                    'correu' => $usuari->correu,
                    'username' => $usuari->username,
                    'rol' => $this->obtenirNomRol($usuari->rol_id),
                ];
            });

        return response()->json($usuaris);
    }

    public function count()
    {
        $count = Usuari::count();

        return response()->json(['total' => $count]);
    }

    public function show($id)
    {
        $usuari = Usuari::find($id);

        if (!$usuari) {
            return response()->json([
                'message' => 'Usuario no encontrado'
            ], 404);
        }

        return response()->json([
            'id' => $usuari->id,
            'nom' => $usuari->nom,
            'cognoms' => $usuari->cognoms,
            'nom_complet' => trim($usuari->nom . ' ' . $usuari->cognoms),
            'correu' => $usuari->correu,
            'username' => $usuari->username,
            'contrasenya' => $usuari->contrasenya,
            'rol_id' => $usuari->rol_id,
            'actiu' => $usuari->actiu,
            'rol' => $this->obtenirNomRol($usuari->rol_id),
        ]);
    }

    public function update(Request $request, $id)
    {
        $usuari = Usuari::find($id);

        if (!$usuari) {
            return response()->json([
                'message' => 'Usuario no encontrado'
            ], 404);
        }

        $request->validate([
            'username' => 'required|string|max:255',
            'contrasenya' => 'required|string|max:255',
            'rol_id' => 'required|integer|in:1,2,3',
            'actiu' => 'required|integer|in:0,1',
        ]);

        $usuari->username = $request->username;
        $usuari->contrasenya = $request->contrasenya;
        $usuari->rol_id = $request->rol_id;
        $usuari->actiu = $request->actiu;

        $usuari->save();

        return response()->json([
            'message' => 'Usuario actualizado correctamente'
        ]);
    }

    private function obtenirNomRol(?int $rolId): string
    {
        if ($rolId === 1) {
            return 'Administrador';
        }

        if ($rolId === 2) {
            return 'Operador';
        }

        if ($rolId === 3) {
            return 'Cliente';
        }

        return 'Sin rol';
    }
}
