<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\UsuariController;
use App\Http\Controllers\OfertaController;


Route::middleware('api')->group(function () {
    Route::get('/clientes-count', [ClientController::class, 'count']);
    Route::get('/clientes', [ClientController::class, 'index']);
    Route::get('/clientes/paises', [ClientController::class, 'paises']); // DEBE IR ANTES DEL {id}
    Route::get('/clientes/ciutats/{paisId}', [ClientController::class, 'ciutats']);
    Route::get('/clientes/{id}', [ClientController::class, 'show']);
    Route::put('/clientes/{id}', [ClientController::class, 'update']);
    Route::post('/clientes', [ClientController::class, 'store']);

    //*Editar usuario*//
    Route::get('/usuarios/{id}', [UsuariController::class, 'show']);
    Route::put('/usuarios/{id}', [UsuariController::class, 'update']);
 


     Route::get('/usuarios-count', [UsuariController::class, 'count']);
    Route::get('/usuarios', [UsuariController::class, 'index']);

    //*Ofertas*//
    Route::get('/ofertas/formulario', [OfertaController::class, 'formulario'])->middleware('web');
Route::get('/ofertas/recientes', [OfertaController::class, 'recientes'])->middleware('web');
Route::post('/ofertas', [OfertaController::class, 'store'])->middleware('web');
Route::get('/ofertas/{id}', [OfertaController::class, 'show'])->middleware('web');
Route::patch('/ofertas/{id}/aceptar', [OfertaController::class, 'aceptarOferta'])->middleware('web');
Route::patch('/ofertas/{id}/rechazar', [OfertaController::class, 'rechazarOferta'])->middleware('web');
Route::get('/ofertas', [OfertaController::class, 'index'])->middleware('web');


});
