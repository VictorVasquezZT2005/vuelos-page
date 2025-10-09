<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\ClienteAuthController;
use App\Http\Controllers\ContactoController;
use App\Http\Controllers\VueloController;
use App\Http\Controllers\ReservacionController;

Route::get('/', function(){ return view('welcome'); })->name('welcome');

Route::get('/register', [ClienteAuthController::class,'showRegisterForm'])->name('register');
Route::post('/register', [ClienteAuthController::class,'register'])->name('register.post');
Route::get('/login', [ClienteAuthController::class,'showLoginForm'])->name('login');
Route::post('/login', [ClienteAuthController::class,'login'])->name('login.post');
Route::post('/logout', [ClienteAuthController::class,'logout'])->name('logout');
Route::post('/contacto/send', [ContactoController::class, 'send'])->name('contacto.send');

Route::middleware('auth')->group(function () {
    Route::get('/vuelos', [VueloController::class, 'index'])->name('vuelos.index');

    Route::get('/reservaciones/create/{vuelo_id}', [ReservacionController::class, 'create'])->name('reservaciones.create');
    Route::post('/reservaciones', [ReservacionController::class, 'store'])->name('reservaciones.store');
});

Route::middleware('auth')->group(function () {
    Route::get('/reservaciones', [ReservacionController::class, 'index'])->name('reservaciones.index');
});