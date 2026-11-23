<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UsuarioController;
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


// Práctica 2: Administración de usuarios
Route::middleware(['auth', 'rol:Administrador,Empleado'])->group(function () {

    Route::get('/usuarios', [UsuarioController::class, 'index'])
        ->name('usuarios.index');

    Route::get('/usuarios/crear', [UsuarioController::class, 'create'])
        ->name('usuarios.create');

    Route::post('/usuarios', [UsuarioController::class, 'store'])
        ->name('usuarios.store');

    Route::get('/usuarios/{usuario}', [UsuarioController::class, 'show'])
        ->name('usuarios.show');

    Route::get('/usuarios/{usuario}/editar', [UsuarioController::class, 'edit'])
        ->name('usuarios.edit');

    Route::put('/usuarios/{usuario}', [UsuarioController::class, 'update'])
        ->name('usuarios.update');

});

// Solamente administradores
Route::middleware(['auth', 'rol:Administrador'])->group(function () {

    Route::delete('/usuarios/{usuario}', [UsuarioController::class, 'destroy'])
        ->name('usuarios.destroy');

    Route::get('/usuarios-eliminados', [UsuarioController::class, 'eliminados'])
        ->name('usuarios.eliminados');

    Route::post('/usuarios-eliminados/{id}/restaurar', [UsuarioController::class, 'restaurar'])
        ->name('usuarios.restaurar');

    Route::delete('/usuarios-eliminados/{id}/eliminar', [UsuarioController::class, 'eliminarPermanente'])
        ->name('usuarios.eliminarPermanente');

});
