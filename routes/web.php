<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ArtistaController;
use App\Http\Controllers\PinturaController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Todas las rutas dentro de este grupo requieren haber iniciado sesión
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Rutas del CRUD para la Gestión de Artistas
    Route::resource('artistas', ArtistaController::class);

    // Rutas del CRUD para la Gestión de Pinturas
    Route::resource('pinturas', PinturaController::class);
});

require __DIR__.'/auth.php';