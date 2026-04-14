<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\UsuariController;

Route::middleware('api')->group(function () {
    Route::get('/clientes-count', [ClientController::class, 'count']);
    Route::get('/clientes', [ClientController::class, 'index']);
    Route::get('/clientes/paises', [ClientController::class, 'paises']); // DEBE IR ANTES DEL {id}
    Route::get('/clientes/ciutats/{paisId}', [ClientController::class, 'ciutats']);
    Route::get('/clientes/{id}', [ClientController::class, 'show']);
    Route::put('/clientes/{id}', [ClientController::class, 'update']);
    Route::post('/clientes', [ClientController::class, 'store']);

    Route::get('/usuarios-count', [UsuariController::class, 'count']);
    Route::get('/usuarios', [UsuariController::class, 'index']);
});

