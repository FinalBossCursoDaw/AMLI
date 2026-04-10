<?php

use Illuminate\Support\Facades\Route;

Route::view('/contacto', 'Contacto')->name('contacto');
Route::view('/register', 'Register')->name('login');
Route::view('/anadir-cliente', 'AnadirCliente')->name('anadir-cliente');
