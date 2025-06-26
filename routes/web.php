<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/pets', function () {
    return view('pets.index');
})->name('pets.index');

Route::get('/pets/create', function () {
    return view('pets.create');
})->name('pets.create');

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::get('/register', function () {
    return view('auth.register');
})->name('register');
