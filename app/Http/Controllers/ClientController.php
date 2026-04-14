<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

use App\Models\Client;
use App\Models\Pais;
use App\Models\Ciutat;


class ClientController extends Controller
{
    public function index()
    {
        $clients = Client::select(
            'id',
            'codi_client',
            'nom_empresa',
            'ciutat',
            'contacte',
            'email',
            'telefon'
        )
        ->where('actiu', 1)
        ->orderBy('nom_empresa')
        ->get();

        return response()->json($clients);
    }

    public function count()
    {
        $count = Client::where('actiu', 1)->count();
        return response()->json(['total' => $count]);
    }
    public function show($id)
    {
        $client = Client::findOrFail($id);

            if (!$client) {
        return response()->json([
            'message' => 'Cliente no encontrado'
        ], 404);
    }
        return response()->json($client);
    }
    public function paissos()
{
    $paissos = Pais::orderBy('nom')->get();

    return response()->json($paissos);
}

public function ciutats($paisId)
{
    $ciutats = Ciutat::where('pais_id', $paisId)
        ->orderBy('nom')
        ->get();

    return response()->json($ciutats);
}

public function update(Request $request, $id)
{
    $client = Client::find($id);

    if (!$client) {
        return response()->json([
            'message' => 'Cliente no encontrado'
        ], 404);
    }

    $client->nom_empresa = $request->nom_empresa;
    $client->cif_nif = $request->cif_nif;
    $client->adreca = $request->adreca;
    $client->ciutat = $request->ciutat;
    $client->codi_postal = $request->codi_postal;
    $client->contacte = $request->contacte;
    $client->email = $request->email;
    $client->telefon = $request->telefon;


    $client->save();

    return response()->json([
        'message' => 'Cliente actualizado correctamente'
    ]);
}

}
