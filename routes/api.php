<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;

Route::middleware('api')->group(function () {
    Route::post('/register', [LoginController::class, 'login']);
});
