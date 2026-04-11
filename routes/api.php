<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ClientController;

Route::middleware('web')->group(function () {
    Route::get('/register', function () {
        return redirect('/register');
    })->name('api.login.view');

    Route::post('/register', [LoginController::class, 'login'])->name('api.login');
});
Route::middleware('api')->group(function () {
    Route::post('/register', [LoginController::class, 'login']);
    Route::get('/clientes-count', [ClientController::class, 'count']);
});
