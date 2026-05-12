<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notificacion extends Model
{
    // Nombre real de la tabla en la base de datos
    protected $table = 'notificacions';

    public $timestamps = false;

    // Campos que permitimos insertar con create()
    protected $fillable = [
        'usuari_id',
        'tipus_notificacio_id',
        'titol',
        'missatge',
        'llegida',
        'data_creacio',
    ];
}