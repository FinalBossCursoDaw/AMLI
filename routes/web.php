<?php

use Illuminate\Support\Facades\Route;


Route::view('/anadir-cliente', 'AnadirCliente')->name('anadir-cliente');



Route::get('/contacto', function () {
    return view('Contacto');
})->name('contacto');


Route::view('/register', 'Register')->name('login');

Route::get('/quienes-somos', function () {
    return view('quienes-somos');
})->name('quienes-somos');

Route::get('/dashboard-admin', function () {
    return view('DashboardAdmin');
})->name('dashboard-admin');
