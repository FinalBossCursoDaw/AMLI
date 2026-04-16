<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Oferta extends Model
{
    public $timestamps = false;

    protected $table = 'ofertes';

    protected $fillable = [
        'codi_oferta',
        'tipus_transport_id',
        'tipus_fluxe_id',
        'tipus_carrega_id',
        'incoterm_id',
        'client_id',
        'comentaris',
        'agent_comercial_id',
        'transportista_id',
        'pes_brut',
        'volum',
        'tipus_validacio_id',
        'port_origen_id',
        'port_desti_id',
        'aeroport_origen_id',
        'aeroport_desti_id',
        'linia_transport_maritim_id',
        'estat_oferta_id',
        'operador_id',
        'data_creacio',
        'data_enviament',
        'data_resposta',
        'data_validessa_inicial',
        'data_validessa_fina',
        'rao_rebuig',
        'tipus_contenidor_id',
        'mida_contenidor',
        'descripcio_producte',
        'preu_estimad',
    ];
}
