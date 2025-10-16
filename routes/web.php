<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\ClienteAuthController;
use App\Http\Controllers\ContactoController;
use App\Http\Controllers\VueloController;
use App\Http\Controllers\ReservacionController;

Route::get('/', function() {
    return view('welcome');
})->name('welcome');

// Rutas de autenticación
Route::get('/register', [ClienteAuthController::class,'showRegisterForm'])->name('register');
Route::post('/register', [ClienteAuthController::class,'register'])->name('register.post');
Route::get('/login', [ClienteAuthController::class,'showLoginForm'])->name('login');
Route::post('/login', [ClienteAuthController::class,'login'])->name('login.post');
Route::post('/logout', [ClienteAuthController::class,'logout'])->name('logout');

// Contacto
Route::post('/contacto/send', [ContactoController::class, 'send'])->name('contacto.send');

// Rutas protegidas por auth
Route::middleware('auth')->group(function () {
    // Vuelos
    Route::get('/vuelos', [VueloController::class, 'index'])->name('vuelos.index');

    // Reservaciones
    Route::get('/reservaciones', [ReservacionController::class, 'index'])->name('reservaciones.index');
    Route::get('/reservaciones/create/{vuelo_id}', [ReservacionController::class, 'create'])->name('reservaciones.create');
    Route::post('/reservaciones', [ReservacionController::class, 'store'])->name('reservaciones.store');
    
    // --- RUTAS AÑADIDAS ---
    // Esta ruta usa el método GET y espera el ID de la reservación. Es para el modal de información.
    Route::get('/reservaciones/{reservacion}', [ReservacionController::class, 'show'])->name('reservaciones.show');
    
    // Esta ruta genera el boleto en PDF para una reservación específica.
    Route::get('/reservaciones/{reservacion}/boleto', [ReservacionController::class, 'generarBoletoPDF'])->name('reservaciones.boleto');
});
