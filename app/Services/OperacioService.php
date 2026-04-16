<?php

namespace App\Services;

use App\Models\Oferta;
use App\Models\Operacio;
use Illuminate\Support\Facades\DB;

class OperacioService
{
    /**
     * Crea una operación a partir de una oferta aceptada
     *
     * @param Oferta $oferta
     * @return Operacio
     */
    public function crearOperacioDesdeOferta(Oferta $oferta): Operacio
    {
        // Generar código único para la operación
        $codiOperacio = $this->generarCodiOperacio();

        // Crear la operación con los datos de la oferta
        $operacio = new Operacio();
        $operacio->codi_operacio = $codiOperacio;
        $operacio->oferta_id = $oferta->id;
        $operacio->client_id = $oferta->client_id;
        $operacio->tipus_transport_id = $oferta->tipus_transport_id;
        $operacio->tipus_fluxe_id = $oferta->tipus_fluxe_id;
        $operacio->tipus_carrega_id = $oferta->tipus_carrega_id;
        $operacio->incoterm_id = $oferta->incoterm_id;
        $operacio->estat_operacio_id = 1; // Estado inicial: "Carrier" o el estado que corresponda
        $operacio->tipus_contenidor_id = $oferta->tipus_contenidor_id;
        $operacio->mida_contenidor = $oferta->mida_contenidor;
        $operacio->descripcio_producte = $oferta->descripcio_producte;
        $operacio->pes_brut = $oferta->pes_brut;
        $operacio->volum = $oferta->volum;
        $operacio->port_origen_id = $oferta->port_origen_id;
        $operacio->port_desti_id = $oferta->port_desti_id;
        $operacio->aeroport_origen_id = $oferta->aeroport_origen_id;
        $operacio->aeroport_desti_id = $oferta->aeroport_desti_id;
        $operacio->linia_transport_maritim_id = $oferta->linia_transport_maritim_id;
        $operacio->transportista_id = $oferta->transportista_id;
        $operacio->data_creacio = now();
        $operacio->ultima_actualitzacio = now();

        $operacio->save();

        return $operacio;
    }

    /**
     * Genera un código único para la operación
     * Formato: OP-YYYY-XXXXXX
     *
     * @return string
     */
    private function generarCodiOperacio(): string
    {
        $any = date('Y');
        $numOperacions = Operacio::whereYear('data_creacio', $any)->count() + 1;
        return sprintf('OP-%d-%06d', $any, $numOperacions);
    }
}
