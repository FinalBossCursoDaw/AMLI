<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Operacio extends Model
{
    public $timestamps = false;

    protected $table = 'operacions';

    protected $fillable = [
        'codi_operacio',
        'oferta_id',
        'client_id',
        'tipus_transport_id',
        'tipus_fluxe_id',
        'tipus_carrega_id',
        'incoterm_id',
        'estat_operacio_id',
        'tipus_contenidor_id',
        'mida_contenidor',
        'descripcio_producte',
        'pes_brut',
        'volum',
        'port_origen_id',
        'port_desti_id',
        'aeroport_origen_id',
        'aeroport_desti_id',
        'linia_transport_maritim_id',
        'transportista_id',
        'data_creacio',
        'ultima_actualitzacio',
    ];

    protected $dates = [
        'data_creacio',
        'ultima_actualitzacio',
    ];

    // Relaciones
    public function oferta()
    {
        return $this->belongsTo(Oferta::class, 'oferta_id');
    }

    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id');
    }

    public function estatOperacio()
    {
        return $this->belongsTo(EstatOperacio::class, 'estat_operacio_id');
    }

    public function tipusTransport()
    {
        return $this->belongsTo(TipusTransport::class, 'tipus_transport_id');
    }

    public function incoterm()
    {
        return $this->belongsTo(Incoterm::class, 'incoterm_id');
    }

    public function transportista()
    {
        return $this->belongsTo(Transportista::class, 'transportista_id');
    }

    public function portOrigen()
    {
        return $this->belongsTo(Port::class, 'port_origen_id');
    }

    public function portDesti()
    {
        return $this->belongsTo(Port::class, 'port_desti_id');
    }
}
