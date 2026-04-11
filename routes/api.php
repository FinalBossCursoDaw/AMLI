<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ClientController;

Route::middleware('api')->group(function () {
    Route::post('/register', [LoginController::class, 'login']);
    Route::get('/clientes-count', [ClientController::class, 'count']);
});