<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\AlumnoController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ProductoController;

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


// PRÁCTICA 3: SISTEMA ACADÉMICO

// Rutas exclusivas para el profesor
Route::middleware(['auth', 'rol:Profesor'])->group(function () {

    Route::get('/alumnos', [AlumnoController::class, 'index'])
        ->name('alumnos.index');

    Route::get('/alumnos/crear', [AlumnoController::class, 'create'])
        ->name('alumnos.create');

    Route::post('/alumnos', [AlumnoController::class, 'store'])
        ->name('alumnos.store');

    Route::get('/alumnos/{id}/editar', [AlumnoController::class, 'edit'])
        ->name('alumnos.edit');

    Route::put('/alumnos/{id}', [AlumnoController::class, 'update'])
        ->name('alumnos.update');

    Route::delete('/alumnos/{id}', [AlumnoController::class, 'destroy'])
        ->name('alumnos.destroy');

});


// Ruta exclusiva para que el alumno consulte su información
Route::middleware(['auth', 'rol:Alumno'])->group(function () {

    Route::get('/mi-informacion-academica', [AlumnoController::class, 'miInformacion'])
        ->name('alumnos.mi-informacion');

});
// Practica 4 gestion categorias 
Route::middleware(['auth', 'rol:Administrador'])->group(function () {

    Route::get('/categorias', [CategoriaController::class, 'index'])
        ->name('categorias.index');

    Route::post('/categorias', [CategoriaController::class, 'store'])
        ->name('categorias.store');

    Route::delete('/categorias/{id}', [CategoriaController::class, 'destroy'])
        ->name('categorias.destroy');

});
// ==========================================
// PRACTICA 4 - ADMINISTRACION DE PRODUCTOS
// ==========================================

// Administrador y Empleado pueden consultar productos
Route::middleware(['auth', 'rol:Administrador,Empleado'])->group(function () {

    Route::get('/productos', [ProductoController::class, 'index'])
        ->name('productos.index');

    Route::get('/productos/{id}', [ProductoController::class, 'show'])
        ->whereNumber('id')
        ->name('productos.show');

});

// Solamente el Administrador puede modificar productos
Route::middleware(['auth', 'rol:Administrador'])->group(function () {

    Route::get('/productos/crear', [ProductoController::class, 'create'])
        ->name('productos.create');

    Route::post('/productos', [ProductoController::class, 'store'])
        ->name('productos.store');

    Route::get('/productos/{id}/editar', [ProductoController::class, 'edit'])
        ->name('productos.edit');

    Route::put('/productos/{id}', [ProductoController::class, 'update'])
        ->name('productos.update');

    Route::delete('/productos/{id}', [ProductoController::class, 'destroy'])
        ->name('productos.destroy');

});