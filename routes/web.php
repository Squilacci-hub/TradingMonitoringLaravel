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

Route::get('/accounts/create', [AccountController::class, 'create'])
    ->middleware('auth')
    ->name('accounts.create');

Route::post('/accounts', [AccountController::class, 'store'])
    ->middleware('auth')
    ->name('accounts.store');

Route::get('/accounts/link', [AccountController::class, 'link'])
    ->middleware('auth')
    ->name('accounts.link');

Route::post('/accounts/link', [AccountController::class, 'linkStore'])
    ->middleware('auth')
    ->name('accounts.link.store');

Route::post('/accounts/sync/{id}', [AccountController::class, 'sync'])
    ->middleware('auth')
    ->name('accounts.sync');


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
