<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\JournalController;
use App\Http\Controllers\TradeController;

Route::get('/', [DashboardController::class, 'index'])
    ->middleware('auth') // Sécurité : connecté seulement
    ->name('dashboard');

Route::get('/journal', [JournalController::class, 'index'])
    ->middleware('auth')
    ->name('journal');

Route::get('/trades/create', [TradeController::class, 'create'])
    ->middleware('auth')
    ->name('trades.create');

Route::post('/trades', [TradeController::class, 'store'])
    ->middleware('auth')
    ->name('trades.store');

use App\Http\Controllers\AccountController;
Route::get('/accounts/select/{id}', [AccountController::class, 'select'])
    ->middleware('auth')
    ->name('accounts.select');

Route::get('/accounts/create', function () {
    return view('accounts.create');
})->middleware('auth')->name('accounts.create');

Route::get('/accounts/connect', function () {
    return view('accounts.connect');
})->middleware('auth')->name('accounts.connect');

Route::post('/accounts', [AccountController::class, 'store'])
    ->middleware('auth')
    ->name('accounts.store');

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
