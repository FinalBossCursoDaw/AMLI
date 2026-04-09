<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;

Route::get('/contacto', function () {
    return view('Contacto');
})->name('contacto');


Route::view('/register', 'Register')->name('login');

Route::get('/quienes-somos', function () {
    return view('quienes-somos');
})->name('quienes-somos');



