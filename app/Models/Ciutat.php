<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ciutat extends Model
{
    public $timestamps = false;

    protected $table = 'ciutats';

    protected $fillable = [
        'nom',
        'pais_id',
    ];
}
