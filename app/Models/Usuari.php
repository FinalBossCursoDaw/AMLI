<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Usuari extends Authenticatable
{
    protected $table = 'usuaris';

    protected $fillable = [
        'username',
        'correu',
        'contrasenya',
        'nom',
        'cognoms',
        'rol_id',
        'client_id',
    ];

    protected $hidden = [
        'contrasenya',
    ];

    public function getAuthPassword()
    {
        return $this->contrasenya;
    }

   
}