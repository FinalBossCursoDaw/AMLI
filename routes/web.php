<?php

use Illuminate\Support\Facades\Route;

Route::view('/contacto', 'Contacto')->name('contacto');
Route::view('/register', 'Register')->name('login');
<<<<<<< HEAD
Route::view('/anadir-cliente', 'AnadirCliente')->name('anadir-cliente');
=======

Route::get('/quienes-somos', function () {
    return view('quienes-somos');
})->name('quienes-somos');



>>>>>>> b1e61e8fde204ef4a90287a0dd3e240e9420f115
