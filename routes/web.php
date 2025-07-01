<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PetController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'home')->name('home');

Route::controller(PetController::class)->group(function () {
    Route::get('/pets/create', 'create')->middleware(['auth'])->name('pets.create');
    Route::post('/pets/create', 'store')->middleware('auth')->name('pets.store');
    Route::get('/pets', 'index')->name('pets.index');
    Route::get('/pets/{pet}', 'show')->name('pets.show');
});

Route::view('/login', 'auth.login')->middleware('guest')->name('login');
Route::post('/login', [AuthController::class, 'authenticate'])->middleware('guest');
Route::view('/register', 'auth.register')->middleware('guest')->name('register');
Route::post('/register', [AuthController::class, 'register'])->middleware('guest');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
