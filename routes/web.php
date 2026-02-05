<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;

Route::get('/', function () {
    // Provisoire : Rediriger vers login si non connecté
    return auth()->check() ? view('dashboard') : redirect()->route('login');
})->name('dashboard'); // Ajout du name pour redirection facile

Route::get('/journal', function () {
    return view('journal');
});

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
