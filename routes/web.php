<?php

use Illuminate\Support\Facades\Route;

Route::get('/login', [\App\Http\Controllers\AuthController::class, 'showLoginForm'])->name('login.form');
Route::post('/login', [\App\Http\Controllers\AuthController::class, 'login'])->name('login');

// Main page route
Route::get('/', [\App\Http\Controllers\MainController::class, 'index'])->name('main');

// Logout route
Route::post('/logout', [\App\Http\Controllers\LogoutController::class, 'logout'])->name('logout');
// Signup (register) routes
Route::get('/register', [\App\Http\Controllers\RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [\App\Http\Controllers\RegisterController::class, 'register']);
