<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

// Halaman awal / landing page
Route::get('/', function () {
    return view('welcome');
});

// Setelah login, arahkan ke todolist (bukan dashboard bawaan)
Route::get('/dashboard', function () {
    return redirect()->route('tasks.index');
})->middleware(['auth', 'verified'])->name('dashboard');

// Route yang membutuhkan login
Route::middleware('auth')->group(function () {
    // Route untuk profile (bawaan breeze)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Route CRUD Todolist
    Route::resource('tasks', TaskController::class);
});

// Route autentikasi (login, register, dll)
require __DIR__.'/auth.php';
