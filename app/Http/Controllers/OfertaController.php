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
            'operador_id' => auth()->id(),

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
public function show(string $id)
{
    if (!auth()->check()) {
        return response()->json([
            'message' => 'Usuario no autenticado',
        ], 401);
    }

    $usuario = auth()->user();

    $query = Oferta::query();

    if (is_numeric($id)) {
        $query->where('id', $id);
    } else {
        $query->where('codi_oferta', $id);
    }

    if ($usuario->rol_id == 2) {
        $query->where('operador_id', $usuario->id);
    } elseif ($usuario->rol_id != 1) {
        $query->where('agent_comercial_id', $usuario->id);
    }

    $oferta = $query->first();

    if (!$oferta) {
        return response()->json([
            'message' => 'Oferta no encontrada',
        ], 404);
    }


      return response()->json([
    'id' => $oferta->id,
    'codi_oferta' => $oferta->codi_oferta,
    'cliente' => $this->obtenerCliente($oferta->client_id),
    'agent_comercial_id' => $oferta->agent_comercial_id,
    'tipus_transport_id' => $oferta->tipus_transport_id,
    'tipus_fluxe_id' => $oferta->tipus_fluxe_id,
    'tipus_carrega_id' => $oferta->tipus_carrega_id,
    'incoterm' => $this->obtenerIncoterm($oferta->incoterm_id),
    'estat_oferta_id' => $oferta->estat_oferta_id,
    'origen' => $this->obtenerOrigen($oferta),
    'destino' => $this->obtenerDestino($oferta),
    'shipping_line' => $this->obtenerShippingLine($oferta->linia_transport_maritim_id),
    'tipo_contenedor' => $this->obtenerTipoContenedor($oferta->tipus_contenidor_id),
    'mida_contenidor' => $oferta->mida_contenidor,
    'pes_brut' => $oferta->pes_brut,
    'volum' => $oferta->volum,
    'descripcio_producte' => $oferta->descripcio_producte,
    'comentaris' => $oferta->comentaris,
    'data_creacio' => $oferta->data_creacio,
    'data_enviament' => $oferta->data_enviament,
    'data_validessa_inicial' => $oferta->data_validessa_inicial,
    'data_validessa_fina' => $oferta->data_validessa_fina,
]);

}
private function obtenerCliente(?int $clientId): string
{
    if (!$clientId) {
        return '-';
    }

    $cliente = DB::table('clients')
        ->where('id', $clientId)
        ->value('nom_empresa');

    if ($cliente) {
        return $cliente;
    }

    return '-';
}
public function index()
{
    if (!auth()->check()) {
        return response()->json([
            'message' => 'Usuario no autenticado',
        ], 401);
    }

    $usuario = auth()->user();

    $query = Oferta::orderByDesc('id');

    $textoEstados = [
        1 => 'Borrador',
        2 => 'Espera',
        3 => 'Aceptada',
        4 => 'Rechazada',
    ];

    $textoModos = [
        1 => 'Maritimo',
        2 => 'Aereo',
        3 => 'Terrestre',
    ];

    $textoTipos = [
        1 => 'Importacion',
        2 => 'Exportacion',
    ];

    if ($usuario->rol_id == 2) {
        $query->where('operador_id', $usuario->id);
    } elseif ($usuario->rol_id != 1) {
        $query->where('agent_comercial_id', $usuario->id);
    }

    $ofertas = $query->get();

    $resultado = $ofertas->map(function ($oferta) use ($textoEstados, $textoModos, $textoTipos) {
        return [
            'id' => $oferta->id,
            'codi_oferta' => $oferta->codi_oferta,
            'tipo' => $textoTipos[$oferta->tipus_fluxe_id] ?? '-',
            'origen' => $this->obtenerOrigen($oferta),
            'destino' => $this->obtenerDestino($oferta),
            'incoterm' => $this->obtenerIncoterm($oferta->incoterm_id),
            'modo' => $textoModos[$oferta->tipus_transport_id] ?? '-',
            'estado' => $textoEstados[$oferta->estat_oferta_id] ?? '-',
            'contenedor' => $this->obtenerTipoContenedor($oferta->tipus_contenidor_id),
        ];
    });

    return response()->json($resultado);
}


private function obtenerIncoterm(?int $incotermId): string
{
    if (!$incotermId) {
        return '-';
    }

    $tipusIncotermId = DB::table('incoterms')
        ->where('id', $incotermId)
        ->value('tipus_incoterm_id');

    if (!$tipusIncotermId) {
        return '-';
    }

    $incoterm = DB::table('tipus_incoterms')
        ->where('id', $tipusIncotermId)
        ->value('codi');

    if ($incoterm) {
        return $incoterm;
    }

    return '-';
}

private function obtenerOrigen(Oferta $oferta): string
{
    if ($oferta->port_origen_id) {
        $puerto = DB::table('ports')
            ->where('id', $oferta->port_origen_id)
            ->value('nom');

        if ($puerto) {
            return $puerto;
        }

        return '-';
    }

    if ($oferta->aeroport_origen_id) {
        $aeropuerto = DB::table('aeroports')
            ->where('id', $oferta->aeroport_origen_id)
            ->value('nom');

        if ($aeropuerto) {
            return $aeropuerto;
        }

        return '-';
    }

    return '-';
}

private function obtenerDestino(Oferta $oferta): string
{
    if ($oferta->port_desti_id) {
        $puerto = DB::table('ports')
            ->where('id', $oferta->port_desti_id)
            ->value('nom');

        if ($puerto) {
            return $puerto;
        }

        return '-';
    }

    if ($oferta->aeroport_desti_id) {
        $aeropuerto = DB::table('aeroports')
            ->where('id', $oferta->aeroport_desti_id)
            ->value('nom');

        if ($aeropuerto) {
            return $aeropuerto;
        }

        return '-';
    }

    return '-';
}

private function obtenerShippingLine(?int $shippingLineId): string
{
    if (!$shippingLineId) {
        return '-';
    }

    $shippingLine = DB::table('linies_transport_maritim')
        ->where('id', $shippingLineId)
        ->value('nom');

    if ($shippingLine) {
        return $shippingLine;
    }

    return '-';
}

private function obtenerTipoContenedor(?int $tipoContenedorId): string
{
    if (!$tipoContenedorId) {
        return '-';
    }

    $tipoContenedor = DB::table('tipus_contenidors')
        ->where('id', $tipoContenedorId)
        ->value('tipus');

    if ($tipoContenedor) {
        return $tipoContenedor;
    }

    return '-';
}


public function updateEstado(Request $request, string $id)
{
    if (!auth()->check()) {
        return response()->json([
            'message' => 'Usuario no autenticado',
        ], 401);
    }

    $usuario = auth()->user();

    if ((int) $usuario->rol_id !== 3) {
        return response()->json([
            'message' => 'Solo el agente comercial puede aceptar o rechazar ofertas',
        ], 403);
    }

    $validated = $request->validate([
        'estat_oferta_id' => 'required|integer|in:3,4',
    ]);

    $query = Oferta::query();

    if (is_numeric($id)) {
        $query->where('id', $id);
    } else {
        $query->where('codi_oferta', $id);
    }

    $query->where('agent_comercial_id', $usuario->id);

    $oferta = $query->first();

    if (!$oferta) {
        return response()->json([
            'message' => 'Oferta no encontrada o no pertenece a este agente comercial',
        ], 404);
    }

    $oferta->estat_oferta_id = $validated['estat_oferta_id'];
    $oferta->save();

    return response()->json([
        'message' => 'Estado actualizado correctamente',
        'id' => $oferta->id,
        'codi_oferta' => $oferta->codi_oferta,
        'estat_oferta_id' => $oferta->estat_oferta_id,
    ]);
}

public function aceptarOferta(string $id)
{
    if (!auth()->check()) {
        return response()->json([
            'message' => 'Usuario no autenticado',
        ], 401);
    }

    $usuario = auth()->user();

    if ((int) $usuario->rol_id !== 3) {
        return response()->json([
            'message' => 'Solo el agente comercial puede aceptar ofertas',
        ], 403);
    }

    $query = Oferta::query();

    if (is_numeric($id)) {
        $query->where('id', $id);
    } else {
        $query->where('codi_oferta', $id);
    }

    $query->where('agent_comercial_id', $usuario->id);

    $oferta = $query->first();

    if (!$oferta) {
        return response()->json([
            'message' => 'Oferta no encontrada o no pertenece a este agente comercial',
        ], 404);
    }

    if ((int) $oferta->estat_oferta_id !== 2) {
        return response()->json([
            'message' => 'Solo se pueden aceptar ofertas en estado Espera',
        ], 422);
    }

    $oferta->estat_oferta_id = 3;
    $oferta->save();

    return response()->json([
        'message' => 'Oferta aceptada correctamente',
        'id' => $oferta->id,
        'codi_oferta' => $oferta->codi_oferta,
        'estat_oferta_id' => $oferta->estat_oferta_id,
    ]);
}


public function rechazarOferta(string $id)
{
    if (!auth()->check()) {
        return response()->json([
            'message' => 'Usuario no autenticado',
        ], 401);
    }

    $usuario = auth()->user();

    if ((int) $usuario->rol_id !== 3) {
        return response()->json([
            'message' => 'Solo el agente comercial puede rechazar ofertas',
        ], 403);
    }

    $query = Oferta::query();

    if (is_numeric($id)) {
        $query->where('id', $id);
    } else {
        $query->where('codi_oferta', $id);
    }

    $query->where('agent_comercial_id', $usuario->id);

    $oferta = $query->first();

    if (!$oferta) {
        return response()->json([
            'message' => 'Oferta no encontrada o no pertenece a este agente comercial',
        ], 404);
    }

    if ((int) $oferta->estat_oferta_id !== 2) {
        return response()->json([
            'message' => 'Solo se pueden rechazar ofertas en estado Espera',
        ], 422);
    }

    $oferta->estat_oferta_id = 4;
    $oferta->save();

    return response()->json([
        'message' => 'Oferta rechazada correctamente',
        'id' => $oferta->id,
        'codi_oferta' => $oferta->codi_oferta,
        'estat_oferta_id' => $oferta->estat_oferta_id,
    ]);
}



}
