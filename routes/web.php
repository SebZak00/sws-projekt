<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EventController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'verified'])->group(function () {
    // Widok ogólny (każdy zalogowany widzi wydarzenia)
    Route::get('/dashboard', [\App\Http\Controllers\EventController::class, 'index'])->name('dashboard');
    Route::post('/events/{event}/register', [\App\Http\Controllers\EventController::class, 'register'])->name('events.register');
    Route::delete('/events/{event}/unregister', [\App\Http\Controllers\EventController::class, 'unregister'])->name('events.unregister');
    
    // TYLKO ADMIN LUB ORGANIZATOR
    Route::middleware('role:admin,organizator')->group(function () {
        Route::get('/events/create', [\App\Http\Controllers\EventController::class, 'create'])->name('events.create');
        Route::post('/events', [\App\Http\Controllers\EventController::class, 'store'])->name('events.store');
    });

    // TYLKO ADMIN
    Route::middleware('role:admin')->group(function () {
        Route::get('/users', [\App\Http\Controllers\UserController::class, 'index'])->name('users.index');
        Route::patch('/users/{user}/role', [\App\Http\Controllers\UserController::class, 'updateRole'])->name('users.updateRole');
    });
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';