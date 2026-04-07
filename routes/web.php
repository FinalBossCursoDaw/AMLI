<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;



Route::get('/register', function () {
    return view('Register');
})->name('register');

