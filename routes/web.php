<?php

use Illuminate\Support\Facades\Route;

Route::get('/login', [\App\Http\Controllers\AuthController::class, 'showLoginForm'])->name('login.form');
Route::post('/login', [\App\Http\Controllers\AuthController::class, 'login'])->name('login');


// Main page route
Route::get('/', [\App\Http\Controllers\TodoController::class, 'index'])->name('main');

// Todo routes
Route::post('/todos', [\App\Http\Controllers\TodoController::class, 'store'])->name('todos.store');
Route::put('/todos/{todo}', [\App\Http\Controllers\TodoController::class, 'update'])->name('todos.update');
Route::delete('/todos/{todo}', [\App\Http\Controllers\TodoController::class, 'destroy'])->name('todos.destroy');
Route::post('/todos/{todo}/checklist', [\App\Http\Controllers\TodoController::class, 'checklist'])->name('todos.checklist');

// Comment routes
Route::post('/todos/{todo}/comments', [\App\Http\Controllers\CommentController::class, 'store'])->name('comments.store');

// Logout route
Route::post('/logout', [\App\Http\Controllers\LogoutController::class, 'logout'])->name('logout');
// Signup (register) routes
Route::get('/register', [\App\Http\Controllers\RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [\App\Http\Controllers\RegisterController::class, 'register']);
