<?php

namespace App\Http\Controllers;

use App\Models\Notificacion;
use Illuminate\Http\Request;
use Throwable;

class NotificacionController extends Controller
{
    public function ultimas()
    {
        try {
            if (!auth()->check()) {
                return response()->json([
                    'message' => 'Usuario no autenticado',
                ], 401);
            }

            $usuario = auth()->user();

            //Buscar ultimas notificacion del usuario 
            $notificaciones = Notificacion::where('usuari_id', $usuario->id)
                ->orderByDesc('data_creacio')
                ->limit(5)
                ->get();

            return response()->json($notificaciones);

     } catch (Throwable $e) {
    return response()->json([
        'message' => 'Error al obtener las notificaciones',
    ], 500);
}
    }
}
