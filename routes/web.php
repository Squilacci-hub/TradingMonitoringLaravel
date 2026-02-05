<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('dashboard');
});

Route::get('/journal', function () {
    return view('journal');
});

Route::get('/strategies', function () {
    return view('strategies');
});
