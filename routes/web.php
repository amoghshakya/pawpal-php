<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PetController;
use App\Models\Pet;
use Illuminate\Support\Facades\Route;

Route::view('/', 'home')->name('home');

Route::controller(PetController::class)->group(function () {
    Route::get('/pets/create', 'create')
        ->middleware(['auth'])
        ->can('create', Pet::class)
        ->name('pets.create');
    Route::post('/pets/create', 'store')
        ->middleware('auth')
        ->can('create', Pet::class)
        ->name('pets.store');
    Route::get('/pets', 'index')->name('pets.index');
    Route::get('/pets/{pet}', 'show')->name('pets.show');
    Route::get('/pets/{pet}/edit', 'edit')
        ->middleware(['auth'])
        ->can('edit', 'pet')
        ->name('pets.edit');
    Route::put('/pets/{pet}/edit', 'update')
        ->middleware(['auth'])
        ->can('edit', 'pet')
        ->name('pets.update');
    Route::get('/pets/{pet}/apply', 'apply')
        ->middleware(['auth'])
        ->can('applyAdoption', 'pet')
        ->name('pets.apply');
    Route::post('/pets/{pet}/apply', 'applyStore')
        ->middleware(['auth'])
        ->can('applyAdoption', 'pet')
        ->name('pets.apply.store');
});

Route::view('/login', 'auth.login')->middleware('guest')->name('login');
Route::post('/login', [AuthController::class, 'authenticate'])->middleware('guest');
Route::view('/register', 'auth.register')->middleware('guest')->name('register');
Route::post('/register', [AuthController::class, 'register'])->middleware('guest');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
