<?php

namespace App\Http\Controllers;

use App\Models\Oferta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OfertaController extends Controller
{
    public function formulario()
    {
        $clientes = DB::table('clients')
            ->select('id', 'nom_empresa')
            ->where('actiu', 1)
            ->orderBy('nom_empresa')
            ->get();

        $incoterms = DB::table('incoterms')
            ->join('tipus_incoterms', 'incoterms.tipus_incoterm_id', '=', 'tipus_incoterms.id')
            ->selectRaw('MIN(incoterms.id) as id, tipus_incoterms.codi, tipus_incoterms.nom')
            ->groupBy('tipus_incoterms.id', 'tipus_incoterms.codi', 'tipus_incoterms.nom')
            ->orderBy('tipus_incoterms.codi')
            ->get();

        $ports = DB::table('ports')
            ->select('id', 'nom')
            ->orderBy('nom')
            ->get();

        $aeroports = DB::table('aeroports')
            ->select('id', 'nom', 'codi')
            ->orderBy('nom')
            ->get();

        $liniesTransportMaritim = DB::table('linies_transport_maritim')
            ->select('id', 'nom')
            ->orderBy('nom')
            ->get();

        $tipusContenidors = DB::table('tipus_contenidors')
            ->select('id', 'tipus')
            ->orderBy('tipus')
            ->get();

$agentsComercials = DB::table('usuaris')
    ->select('id', 'nom', 'cognoms')
    ->where('actiu', 1)
    ->where('rol_id', 3)
    ->orderBy('nom')
    ->get();

        return response()->json([
            'clientes' => $clientes,
            'incoterms' => $incoterms,
            'ports' => $ports,
            'aeroports' => $aeroports,
            'linies_transport_maritim' => $liniesTransportMaritim,
            'tipus_contenidors' => $tipusContenidors,
            'agents_comercials' => $agentsComercials,
        ]);

        
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'client_id' => 'required|integer|exists:clients,id',
            'agent_comercial_id' => 'nullable|integer|exists:usuaris,id',
            'tipus_transport_id' => 'required|integer|exists:tipus_transports,id',
            'tipus_fluxe_id' => 'required|integer|exists:tipus_fluxes,id',
            'tipus_carrega_id' => 'required|integer|exists:tipus_carrega,id',
            'incoterm_id' => 'required|integer|exists:incoterms,id',
            'comentaris' => 'nullable|string|max:255',
            'pes_brut' => 'nullable|numeric',
            'volum' => 'nullable|numeric',
            'port_origen_id' => 'nullable|integer|exists:ports,id',
            'port_desti_id' => 'nullable|integer|exists:ports,id',
            'aeroport_origen_id' => 'nullable|integer|exists:aeroports,id',
            'aeroport_desti_id' => 'nullable|integer|exists:aeroports,id',
            'linia_transport_maritim_id' => 'nullable|integer|exists:linies_transport_maritim,id',
            'tipus_contenidor_id' => 'nullable|integer|exists:tipus_contenidors,id',
            'mida_contenidor' => 'nullable|string|max:10',
            'descripcio_producte' => 'nullable|string|max:500',
            'data_validessa_fina' => 'nullable|date',
        ]);

        $oferta = Oferta::create([
            'codi_oferta' => $this->generarCodigoOferta(),
            'agent_comercial_id' => $validated['agent_comercial_id'] ?? null,
            'tipus_transport_id' => $validated['tipus_transport_id'],
            'tipus_fluxe_id' => $validated['tipus_fluxe_id'],
            'tipus_carrega_id' => $validated['tipus_carrega_id'],
            'incoterm_id' => $validated['incoterm_id'],
            'client_id' => $validated['client_id'],
            'comentaris' => $validated['comentaris'] ?? null,
            'pes_brut' => $validated['pes_brut'] ?? null,
            'volum' => $validated['volum'] ?? null,
            'tipus_validacio_id' => 1,
            'port_origen_id' => $validated['port_origen_id'] ?? null,
            'port_desti_id' => $validated['port_desti_id'] ?? null,
            'aeroport_origen_id' => $validated['aeroport_origen_id'] ?? null,
            'aeroport_desti_id' => $validated['aeroport_desti_id'] ?? null,
            'linia_transport_maritim_id' => $validated['linia_transport_maritim_id'] ?? null,
            'estat_oferta_id' => 2,
            'operador_id' => 1,
            'data_creacio' => now()->format('Y-m-d'),
            'data_enviament' => now()->format('Y-m-d'),
            'data_validessa_inicial' => now()->format('Y-m-d'),
            'data_validessa_fina' => $validated['data_validessa_fina'] ?? null,
            'tipus_contenidor_id' => $validated['tipus_contenidor_id'] ?? null,
            'mida_contenidor' => $validated['mida_contenidor'] ?? null,
            'descripcio_producte' => $validated['descripcio_producte'] ?? null,
        ]);

        return response()->json([
            'message' => 'Oferta creada correctamente',
            'oferta' => $oferta,
        ], 201);
    }

    private function generarCodigoOferta(): string
    {
        $ultimaOferta = Oferta::latest('id')->first();
        $seguentNumero = $ultimaOferta ? ($ultimaOferta->id + 1) : 1;

        return 'OF-' . date('Y') . '-' . str_pad($seguentNumero, 4, '0', STR_PAD_LEFT);
    }
    
    public function recientes()
{
    $usuario = auth()->user();

    $query = Oferta::orderByDesc('id');

    if ($usuario->rol_id == 2) {
        $query->where('operador_id', $usuario->id);
    } else {
        $query->where('agent_comercial_id', $usuario->id);
    }

    $ofertas = $query->limit(5)->get([
        'id',
        'codi_oferta',
        'incoterm_id',
        'estat_oferta_id',
        'port_origen_id',
        'port_desti_id',
        'aeroport_origen_id',
        'aeroport_desti_id',
        'data_creacio',
    ]);

    return response()->json($ofertas);
}



}
