<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\JournalController;

Route::get('/', [DashboardController::class, 'index'])
    ->middleware('auth') // Sécurité : connecté seulement
    ->name('dashboard');

Route::get('/journal', [JournalController::class, 'index'])
    ->middleware('auth')
    ->name('journal');

Route::get('/strategies', function () {
    return view('strategies');
});

// Affiche le formulaire (GET)
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

// Traite les données (POST)
Route::post('/login', [AuthController::class, 'login']);

// Affiche le formulaire (GET)
Route::get('/register', function () {
    return view('auth.register');
})->name('register');

// Traite les données (POST)
Route::post('/register', [AuthController::class, 'register']);

// Logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
