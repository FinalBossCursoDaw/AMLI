<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return response('Proyecto base listo. Sin paginas web.');
})->name('home');

Route::get('/register', function () {
    return Inertia::render('auth/Register');
})->name('register');

