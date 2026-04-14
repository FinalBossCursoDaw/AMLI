<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Client;


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
    
    public function paises()
    {
        try {
            $paises = DB::table('paissos')
                ->select('id', 'nom')
                ->orderBy('nom')
                ->get();

            return response()->json($paises);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function ciutats($paisId)
    {
        $ciutats = DB::table('ciutats')
            ->where('pais_id', $paisId)
            ->select('id', 'nom')
            ->orderBy('nom')
            ->get();

        return response()->json($ciutats);
    }

public function store(Request $request)
{
    $validated = $request->validate([
        'nom_empresa' => 'required|string|max:150',
        'cif_nif' => 'required|string|max:30|unique:clients,cif_nif',
        'pais_id' => 'required|integer|exists:paissos,id',
        'ciutat' => 'required|string|max:100',
        'codi_postal' => 'nullable|string|max:20',
        'adreca' => 'required|string|max:200',
        'contacte' => 'required|string|max:100',
        'email' => 'required|email|max:150',
        'telefon' => 'required|string|max:30',
        'observacions' => 'nullable|string|max:500',
    ]);

    try {
        $codiClient = $this->generateClientCode();

        $client = Client::create([
            'codi_client' => $codiClient,
            'nom_empresa' => $validated['nom_empresa'],
            'cif_nif' => $validated['cif_nif'],
            'adreca' => $validated['adreca'],
            'ciutat' => $validated['ciutat'],
            'codi_postal' => $validated['codi_postal'] ?? '',
            'pais_id' => $validated['pais_id'],
            'contacte' => $validated['contacte'],
            'email' => $validated['email'],
            'telefon' => $validated['telefon'],
            'observacions' => $validated['observacions'] ?? '',
            'actiu' => 1,
            'data_creacio' => DB::raw('GETDATE()'),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Cliente creado correctamente.',
            'client' => $client
        ], 201);

    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Error al crear el cliente: ' . $e->getMessage()
        ], 500);
    }
}

private function generateClientCode(): string
{
    $prefix = 'CLT-';
    $lastClient = Client::latest('id')->first();
    $nextNumber = $lastClient ? ($lastClient->id + 1) : 1;
    
    return $prefix . str_pad($nextNumber, 5, '0', STR_PAD_LEFT);
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
