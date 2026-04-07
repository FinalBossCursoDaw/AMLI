<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;

Route::get('/contacto', function () {
    return Inertia::render('auth/Contacto');
})->name('contacto');


Route::get('/register', function () {
    return view('Register');
})->name('register');

