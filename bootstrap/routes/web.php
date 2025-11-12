<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TareaController;

// Ruta principal
Route::get('/', function () {
    return redirect()->route('login');
});

// Rutas de autenticación (públicas)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.post');
});

// Rutas protegidas (requieren autenticación)
Route::middleware('auth')->group(function () {
    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Dashboard
    Route::get('/dashboard', function () {
        return view('welcome');
    })->name('dashboard');

    // Tareas - Resource routes
    Route::resource('tareas', TareaController::class)->except(['show']);

    // Página de Tareas API
    Route::get('/tareas-api', function () {
        return view('tareas-api.index');
    })->name('tareas-api.index');
});

