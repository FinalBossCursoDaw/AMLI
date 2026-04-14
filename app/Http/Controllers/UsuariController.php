<?php

namespace App\Http\Controllers;

use App\Models\Usuari;

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

    private function obtenirNomRol(int $rolId): string
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
