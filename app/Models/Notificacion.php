<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notificacion extends Model
{
    // La tabla usa el nombre de la base de datos, no el plural automatico de Laravel.
    protected $table = 'notificacions';

    // La fecha se guarda en data_creacio, por eso no usamos created_at ni updated_at.
    public $timestamps = false;

    // Campos permitidos para insertar notificaciones con Notificacion::create().
    protected $fillable = [
        'usuari_id',
        'tipus_notificacio_id',
        'titol',
        'missatge',
        'llegida',
        'data_creacio',
    ];
}
