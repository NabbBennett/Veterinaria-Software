<?php

use Illuminate\Support\Facades\Route;

// Página principal pública
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Rutas del área admin
Route::prefix('admin')->name('admin.')->group(function () {
    // Página de acceso con clave
    Route::get('/', function () {
        return view('admin.index');
    })->name('index');
    
    // Login
    Route::get('/login', function () {
        return view('admin.login');
    })->name('login');
    
    // Registro
    Route::get('/register', function () {
        return view('admin.register');
    })->name('register');
    
    // Dashboard y sus secciones
    Route::prefix('dashboard')->name('dashboard.')->group(function () {
        // Dashboard principal
        Route::get('/', function () {
            return view('admin.dashboard');
        })->name('index');
        
        // Secciones del dashboard
        Route::get('/pacientes', function () {
            return view('admin.dashboard.pacientes');
        })->name('pacientes');
        
        Route::get('/citas', function () {
            return view('admin.dashboard.citas');
        })->name('citas');
        
        Route::get('/inventario', function () {
            return view('admin.dashboard.inventario');
        })->name('inventario');
        
        Route::get('/servicios', function () {
            return view('admin.dashboard.servicios');
        })->name('servicios');
        
        Route::get('/caja', function () {
            return view('admin.dashboard.caja');
        })->name('caja');
    });
});