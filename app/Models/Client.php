<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    public $timestamps = false;
    protected $table = 'clients';

    protected $fillable = [
        'codi_client',
        'nom_empresa',
        'cif_nif',
        'adreca',
        'ciutat',
        'codi_postal',
        'pais_id',
        'contacte',
        'email',
        'telefon',
        'observacions',
        'actiu',
        'data_creacio',
        'data_actualitzacio',
    ];
}