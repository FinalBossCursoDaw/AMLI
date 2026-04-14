<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\UsuariController;

Route::middleware('api')->group(function () {
    Route::get('/clientes-count', [ClientController::class, 'count']);
    Route::get('/clientes', [ClientController::class, 'index']);
    Route::get('/clientes/{id}', [ClientController::class, 'show']);
    //*Editar cliente*//
    Route::put('/clientes/{id}', [ClientController::class, 'update']);


    //*Editar usuario*//
    Route::get('/usuarios/{id}', [UsuariController::class, 'show']);
    Route::put('/usuarios/{id}', [UsuariController::class, 'update']);
 


     Route::get('/usuarios-count', [UsuariController::class, 'count']);
    Route::get('/usuarios', [UsuariController::class, 'index']);

    Route::get('/paissos', [ClientController::class, 'paissos']);
    Route::get('/ciutats/{paisId}', [ClientController::class, 'ciutats']);


});
