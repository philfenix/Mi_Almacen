<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\PaginaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\FiadoController;

// Redirigir la raíz del sitio al login
Route::get('/', function () {
    return redirect('/login');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'mostrarDashboard'])->name('dashboard');
    Route::get('/perfil', [ProfileController::class, 'show'])->name('perfil');
    Route::post('/perfil', [ProfileController::class, 'updateProfile'])->name('perfil.update');
    Route::post('/perfil/cambiar-contrasena', [ProfileController::class, 'updatePassword'])->name('perfil.cambiar-contrasena');
});

Route::get('/productos/categoria/{id}', [PaginaController::class, 'mostrarProductosPorCategoria'])->name('productos.categoria');
Route::get('/inventario', [DashboardController::class, 'mostrarInventario'])->name('inventario');
Route::post('/eliminar-productos-seleccionados', [PaginaController::class, 'eliminarProductosSeleccionados'])->name('eliminarProductosSeleccionados');
Route::get('/productos-por-categoria', [PaginaController::class, 'productosPorCategoria'])->name('productos.por.categoria');


Route::get('/agregar-producto', [PaginaController::class, 'mostrarPagina'])->name('agregar-producto');
Route::post('/guardar-producto', [PaginaController::class, 'guardarProducto'])->name('guardarProducto');
Route::delete('/eliminar-producto/{id}', [PaginaController::class, 'eliminarProducto'])->name('eliminarProducto');
Route::get('/editar-producto/{id}', [PaginaController::class, 'editarProducto'])->name('editarProducto');
Route::put('/actualizar-producto/{id}', [PaginaController::class, 'actualizarProducto'])->name('actualizarProducto');



Route::get('/fiados', [FiadoController::class, 'index'])->name('fiados.index');
Route::post('/fiados', [FiadoController::class, 'store'])->name('fiados.store');
Route::delete('/fiados/{id}', [FiadoController::class, 'destroy'])->name('fiados.destroy');



// Rutas de restablecimiento de contraseña
Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])->name('password.request');
Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])->name('password.email');
Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])->name('password.reset');
Route::post('reset-password', [NewPasswordController::class, 'store'])->name('password.update');

// Incluir las rutas de autenticación generadas por Breeze
require __DIR__ . '/auth.php';