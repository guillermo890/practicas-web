<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

// Página inicial: enviar al login
Route::get('/', function () {
    return redirect()->route('login');
});

// Inicio de sesión
Route::get('/login', [AuthController::class, 'mostrarLogin'])
    ->name('login');

Route::post('/login', [AuthController::class, 'iniciarSesion'])
    ->name('login.post');

// Cerrar sesión
Route::post('/logout', [AuthController::class, 'cerrarSesion'])
    ->name('logout');

// Área protegida
Route::middleware('auth')->group(function () {

    Route::get('/inicio', function () {
        return view('inicio');
    })->name('inicio');

});

// Verificación de administrador
Route::middleware('codigo.pendiente')->group(function () {

    Route::get('/verificar-codigo', [AuthController::class, 'mostrarVerificacion'])
        ->name('verificar.codigo');

    Route::post('/verificar-codigo', [AuthController::class, 'verificarCodigo'])
        ->name('verificar.codigo.post');

});