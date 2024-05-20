<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\GenreController;

/* Route::get('/', function () {
    return view('signup-login');
})->name('signup-login'); */

Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/signup-login', function () {

    return view('signup-login');
})->name('signup-login');
Route::post('/create-user', [UserController::class, 'create_user']);
Route::get('/create-user', function () {

    return redirect()->route('signup-login');
});

Route::post('/store-book', [BookController::class, 'storebook']);
Route::get('/add-book', function () {

    return view('add-book');
});
Route::get('/search-genre', [GenreController::class, 'searchGenres']);
Route::post('/login', [UserController::class, 'login']);
