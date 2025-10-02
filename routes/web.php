<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Login routes
Route::get('/login', [\App\Http\Controllers\AuthController::class, 'showLoginForm'])->name('login.form');
Route::post('/login', [\App\Http\Controllers\AuthController::class, 'login'])->name('login');
