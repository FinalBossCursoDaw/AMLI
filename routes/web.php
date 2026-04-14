<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\LoginController;


Route::get('/anadir-cliente', function () {
    if (!Auth::check()) {
        return redirect('/register');
    }

    if (Auth::user()->rol_id != 1 && Auth::user()->rol_id != 2) {
        return redirect('/dashboard-operador-cliente');
    }

    return view('AnadirCliente');
})->name('anadir-cliente');

Route::get('/editar-cliente', function () {
    if (!Auth::check()) {
        return redirect('/register');
    }

    return view('EditarCliente');
})->name('editar-cliente');

Route::get('/ofertas', function () {
    if (!Auth::check()) {
        return redirect('/register');
    }

    if (Auth::user()->rol_id == 1) {
        return redirect('/dashboard-admin');
    }

    return view('Ofertas');
})->name('ofertas');

Route::get('/operaciones', function () {
    if (!Auth::check()) {
        return redirect('/register');
    }

    if (Auth::user()->rol_id == 1) {
        return redirect('/dashboard-admin');
    }

    return view('Operaciones');
})->name('operaciones');


Route::get('/contacto', function () {
    return view('Contacto');
})->name('contacto');


Route::view('/register', 'Register')->name('login');
Route::post('/register', [LoginController::class, 'login'])->name('login.post');

Route::get('/quienes-somos', function () {
    return view('quienes-somos');
})->name('quienes-somos');

Route::get('/dashboard-admin', function () {
    if (!Auth::check()) {
        return redirect('/register');
    }

    if (Auth::user()->rol_id != 1 && Auth::user()->rol_id != 2) {
        return redirect('/dashboard-operador-cliente');
    }

    return view('DashboardAdmin');
})->name('dashboard-admin');

Route::get('/dashboard-operador-cliente', function () {
    if (!Auth::check()) {
        return redirect('/register');
    }

    if (Auth::user()->rol_id == 1) {
        return redirect('/dashboard-admin');
    }

    return view('DashboardOperadorCliente');
})->name('dashboard-operador-cliente');
