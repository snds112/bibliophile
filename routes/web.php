<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

/* Route::get('/', function () {
    return view('signup-login');
})->name('signup-login'); */

Route::get('/', function () {
    return view('home');
})->name('home');
Route::post('/create-user', [userController::class, 'create_user']);
Route::get('/create-user', function () {

    return redirect()->route('signup-login');
});

Route::post('/login', [UserController::class, 'login']);
