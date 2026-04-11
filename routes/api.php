<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;

Route::middleware('web')->group(function () {
    Route::get('/register', function () {
        return redirect('/register');
    })->name('api.login.view');

    Route::post('/register', [LoginController::class, 'login'])->name('api.login');
});
