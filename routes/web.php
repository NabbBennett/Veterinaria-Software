<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\AdminAuthController;
use App\Http\Controllers\PacienteController;
use App\Http\Controllers\CitaController;
use App\Http\Controllers\InventarioController;
use App\Http\Controllers\ServicioController;
use App\Http\Controllers\CajaController;
use App\Http\Controllers\ProfileController;

// Ruta principal
Route::get('/', [WelcomeController::class, 'index'])->name('welcome');

// Rutas de acceso administrativo
Route::prefix('admin')->group(function () {
    Route::get('/access', [AdminController::class, 'showAccessForm'])->name('admin.access');
    Route::post('/access', [AdminController::class, 'verifyAccess']);
    Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
    Route::post('/login', [AdminAuthController::class, 'login']);
    Route::get('/register', [AdminAuthController::class, 'showRegisterForm'])->name('admin.register');
    Route::post('/register', [AdminAuthController::class, 'register'])->name('admin.register.submit');
    Route::post('/logout', [AdminAuthController::class, 'logoutUser'])->name('admin.logout');
});

// Rutas de Dashboard
Route::prefix('admin/dashboard')->group(function () {
    // Dashboard principal
    Route::get('/', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    
    // Pacientes
    Route::get('/pacientes', [PacienteController::class, 'index'])->name('admin.dashboard.pacientes');
    Route::post('/pacientes', [PacienteController::class, 'store'])->name('admin.dashboard.pacientes.store');
    Route::get('/pacientes/{id}', [PacienteController::class, 'show']);
    Route::get('/pacientes/{id}/edit', [PacienteController::class, 'edit']);
    Route::put('/pacientes/{id}', [PacienteController::class, 'update'])->name('admin.dashboard.pacientes.update');
    Route::delete('/pacientes/{id}', [PacienteController::class, 'destroy'])->name('admin.dashboard.pacientes.destroy');

    // Rutas de citas
    Route::get('/citas', [CitaController::class, 'index'])->name('admin.dashboard.citas');
    Route::get('/citas/crear', [CitaController::class, 'create'])->name('admin.dashboard.citas.create');
    Route::post('/citas', [CitaController::class, 'store'])->name('admin.dashboard.citas.store');
    Route::get('/citas/count', [CitaController::class, 'countCitas'])->name('admin.dashboard.citas.count');
    Route::get('/citas/por-fecha', [CitaController::class, 'citasPorFecha'])->name('admin.dashboard.citas.por-fecha');
    Route::put('/citas/{id}/cambiar-estado', [CitaController::class, 'cambiarEstado'])->name('admin.dashboard.citas.cambiar-estado');
    Route::get('/citas/{id}', [CitaController::class, 'show'])->name('admin.dashboard.citas.show');
    Route::get('/citas/{id}/editar', [CitaController::class, 'edit'])->name('admin.dashboard.citas.edit');
    Route::put('/citas/{id}', [CitaController::class, 'update'])->name('admin.dashboard.citas.update');
    Route::delete('/citas/{id}', [CitaController::class, 'destroy'])->name('admin.dashboard.citas.destroy');
    Route::get('/citas/{id}/ver', [CitaController::class, 'verModal'])->name('admin.dashboard.citas.ver');

    // Inventario
    Route::get('/inventario', [InventarioController::class, 'index'])->name('admin.dashboard.inventario');
    Route::post('/inventario', [InventarioController::class, 'store'])->name('admin.dashboard.inventario.store');
    Route::get('/inventario/{id}/edit', [InventarioController::class, 'edit']);
    Route::put('/inventario/{id}', [InventarioController::class, 'update'])->name('admin.dashboard.inventario.update');
    Route::delete('/inventario/{id}', [InventarioController::class, 'destroy'])->name('admin.dashboard.inventario.destroy');
    Route::post('/inventario/{id}/aumentar-stock', [InventarioController::class, 'aumentarStock']);
    Route::post('/inventario/{id}/disminuir-stock', [InventarioController::class, 'disminuirStock']);
    
    // Servicios
    Route::get('/servicios', [ServicioController::class, 'index'])->name('admin.dashboard.servicios');
    Route::post('/servicios', [ServicioController::class, 'storeServicio'])->name('admin.dashboard.servicios.store');
    Route::post('/servicios/realizar', [ServicioController::class, 'realizarServicio'])->name('admin.dashboard.servicios.realizar');
    Route::get('/servicios/{id}/edit', [ServicioController::class, 'edit']);
    Route::put('/servicios/{id}', [ServicioController::class, 'update'])->name('admin.dashboard.servicios.update');
    Route::delete('/servicios/{id}', [ServicioController::class, 'destroy'])->name('admin.dashboard.servicios.destroy');

    // Caja
    Route::get('/caja', [CajaController::class, 'index'])->name('admin.dashboard.caja');
    Route::post('/caja', [CajaController::class, 'store'])->name('admin.dashboard.caja.store');
    Route::get('/caja/registrar', [CajaController::class, 'create'])->name('admin.dashboard.caja.create');
    Route::get('/caja/reporte', [CajaController::class, 'reporte'])->name('admin.dashboard.caja.reporte');

    // ticket de venta
    Route::get('/caja/ticket/{venta_id}', [CajaController::class, 'generarTicket'])->name('admin.dashboard.caja.ticket');
    Route::get('/caja/ticket/{venta_id}/ver', [CajaController::class, 'verTicket'])->name('admin.dashboard.caja.ticket.ver');
    Route::get('/caja/ticket/{venta_id}/completo', [CajaController::class, 'mostrarTicket'])->name('admin.dashboard.caja.ticket.completo');

    // Perfil de usuario
    Route::get('/perfil', [ProfileController::class, 'show'])->name('admin.dashboard.profile');
    Route::put('/perfil/actualizar', [ProfileController::class, 'updateProfile'])->name('admin.dashboard.profile.update');
    Route::post('/perfil/password', [ProfileController::class, 'updatePassword'])->name('admin.dashboard.profile.password');

});