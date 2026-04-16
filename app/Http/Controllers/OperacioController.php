<?php

namespace App\Http\Controllers;

use App\Models\Operacio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OperacioController extends Controller
{
    /**
     * Obtiene el listado de operaciones con filtrados opcionales
     */
    public function index(Request $request)
    {
        if (!auth()->check()) {
            return response()->json([
                'message' => 'Usuario no autenticado',
            ], 401);
        }

        $usuario = auth()->user();
        $query = Operacio::query();

        // Si es operador, solo ver sus propias operaciones
        if ($usuario->rol_id == 2) {
            $query->whereHas('oferta', function ($q) use ($usuario) {
                $q->where('operador_id', $usuario->id);
            });
        }

        // Aplicar filtros si se proporcionan
        if ($request->has('id') && $request->id) {
            $query->where('codi_operacio', $request->id);
        }

        if ($request->has('cliente_id') && $request->cliente_id) {
            $query->where('client_id', $request->cliente_id);
        }

        if ($request->has('tipo') && $request->tipo) {
            // Tipo se refiere al flujo (Import/Export)
            $tiposFluxes = [
                'Import' => 1,
                'Export' => 2,
            ];
            $fluxeId = $tiposFluxes[$request->tipo] ?? null;
            if ($fluxeId) {
                $query->where('tipus_fluxe_id', $fluxeId);
            }
        }

        if ($request->has('estado') && $request->estado) {
            // Estado puede ser por codi_operacio o por estat_operacio_id
            $query->where('estat_operacio_id', $request->estado);
        }

        // Ordenar por más recientes
        $query->orderByDesc('data_creacio');

        $operaciones = $query->get();

        $resultado = $operaciones->map(function ($op) {
            return [
                'id' => $op->codi_operacio,
                'cliente' => $this->obtenerCliente($op->client_id),
                'tipo' => $this->obtenerTipo($op->tipus_fluxe_id),
                'origen' => $this->obtenerOrigen($op),
                'destino' => $this->obtenerDestino($op),
                'incoterm' => $this->obtenerIncoterm($op->incoterm_id),
                'modo' => $this->obtenerModo($op->tipus_transport_id),
                'estado' => $this->obtenerEstado($op->estat_operacio_id),
                'actualizacion' => $this->obtenerTiempoTranscurrido($op->ultima_actualitzacio),
            ];
        });

        return response()->json($resultado);
    }

    /**
     * Obtiene el detalle de una operación específica
     */
    public function show(string $id)
    {
        if (!auth()->check()) {
            return response()->json([
                'message' => 'Usuario no autenticado',
            ], 401);
        }

        $usuario = auth()->user();

        $query = Operacio::where('codi_operacio', $id)
            ->orWhere('id', $id);

        // Si es operador, solo ver sus propias operaciones
        if ($usuario->rol_id == 2) {
            $query->whereHas('oferta', function ($q) use ($usuario) {
                $q->where('operador_id', $usuario->id);
            });
        }

        $operacio = $query->first();

        if (!$operacio) {
            return response()->json([
                'message' => 'Operación no encontrada',
            ], 404);
        }

        return response()->json([
            'id' => $operacio->id,
            'codi_operacio' => $operacio->codi_operacio,
            'cliente' => $this->obtenerCliente($operacio->client_id),
            'tipo' => $this->obtenerTipo($operacio->tipus_fluxe_id),
            'origen' => $this->obtenerOrigen($operacio),
            'destino' => $this->obtenerDestino($operacio),
            'incoterm' => $this->obtenerIncoterm($operacio->incoterm_id),
            'modo' => $this->obtenerModo($operacio->tipus_transport_id),
            'estado' => $this->obtenerEstado($operacio->estat_operacio_id),
            'contenedor' => $this->obtenerTipoContenedor($operacio->tipus_contenidor_id),
            'mida_contenidor' => $operacio->mida_contenidor,
            'peso' => $operacio->pes_brut,
            'volumen' => $operacio->volum,
            'descripcion_producto' => $operacio->descripcio_producte,
            'transportista' => $this->obtenerTransportista($operacio->transportista_id),
            'data_creacio' => $operacio->data_creacio,
            'ultima_actualitzacio' => $operacio->ultima_actualitzacio,
        ]);
    }

    /**
     * Actualiza el estado de una operación
     */
    public function updateEstado(Request $request, string $id)
    {
        if (!auth()->check()) {
            return response()->json([
                'message' => 'Usuario no autenticado',
            ], 401);
        }

        $usuario = auth()->user();

        if ($usuario->rol_id != 1 && $usuario->rol_id != 3) {
            return response()->json([
                'message' => 'No tienes permiso para actualizar operaciones',
            ], 403);
        }

        $validated = $request->validate([
            'estat_operacio_id' => 'required|integer',
        ]);

        $query = Operacio::where('codi_operacio', $id)
            ->orWhere('id', $id);

        if ($usuario->rol_id == 2) {
            $query->whereHas('oferta', function ($q) use ($usuario) {
                $q->where('operador_id', $usuario->id);
            });
        }

        $operacio = $query->first();

        if (!$operacio) {
            return response()->json([
                'message' => 'Operación no encontrada',
            ], 404);
        }

        $operacio->estat_operacio_id = $validated['estat_operacio_id'];
        $operacio->ultima_actualitzacio = now();
        $operacio->save();

        return response()->json([
            'message' => 'Estado actualizado correctamente',
            'operacio' => [
                'id' => $operacio->id,
                'codi_operacio' => $operacio->codi_operacio,
                'estado' => $this->obtenerEstado($operacio->estat_operacio_id),
            ],
        ]);
    }

    // Métodos auxiliares
    private function obtenerCliente(?int $clientId): string
    {
        if (!$clientId) {
            return '-';
        }

        $cliente = DB::table('clients')
            ->where('id', $clientId)
            ->value('nom_empresa');

        return $cliente ?? '-';
    }

    private function obtenerTipo(?int $fluxeId): string
    {
        $tipos = [
            1 => 'Import',
            2 => 'Export',
        ];

        return $tipos[$fluxeId] ?? '-';
    }

    private function obtenerOrigen(Operacio $operacio): string
    {
        if ($operacio->port_origen_id) {
            $puerto = DB::table('ports')
                ->where('id', $operacio->port_origen_id)
                ->value('nom');
            return $puerto ?? '-';
        }

        if ($operacio->aeroport_origen_id) {
            $aeropuerto = DB::table('aeroports')
                ->where('id', $operacio->aeroport_origen_id)
                ->value('nom');
            return $aeropuerto ?? '-';
        }

        return '-';
    }

    private function obtenerDestino(Operacio $operacio): string
    {
        if ($operacio->port_desti_id) {
            $puerto = DB::table('ports')
                ->where('id', $operacio->port_desti_id)
                ->value('nom');
            return $puerto ?? '-';
        }

        if ($operacio->aeroport_desti_id) {
            $aeropuerto = DB::table('aeroports')
                ->where('id', $operacio->aeroport_desti_id)
                ->value('nom');
            return $aeropuerto ?? '-';
        }

        return '-';
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

        return $incoterm ?? '-';
    }

    private function obtenerModo(?int $transportId): string
    {
        $modos = [
            1 => 'Maritimo',
            2 => 'Aereo',
            3 => 'Terrestre',
        ];

        return $modos[$transportId] ?? '-';
    }

    private function obtenerEstado(?int $estatId): string
    {
        // Estados de operación
        $estados = [
            1 => 'Carrier',
            2 => 'Buyer',
            3 => 'Seller',
            4 => 'Vessel',
            5 => 'En transito',
            6 => 'Entregada',
        ];

        return $estados[$estatId] ?? '-';
    }

    private function obtenerTipoContenedor(?int $tipoId): string
    {
        if (!$tipoId) {
            return '-';
        }

        $tipo = DB::table('tipus_contenidors')
            ->where('id', $tipoId)
            ->value('tipus');

        return $tipo ?? '-';
    }

    private function obtenerTransportista(?int $transportistaId): string
    {
        if (!$transportistaId) {
            return '-';
        }

        $transportista = DB::table('transportistes')
            ->where('id', $transportistaId)
            ->value('nom');

        return $transportista ?? '-';
    }

    private function obtenerTiempoTranscurrido($fecha): string
    {
        if (!$fecha) {
            return '-';
        }

        $ahora = now();
        $diferencia = $ahora->diffForHumans($fecha, ['parts' => 1, 'absolute' => true]);

        return 'Hace ' . $diferencia;
    }
}
