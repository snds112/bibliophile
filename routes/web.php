<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

Route::get('/', function () {
    return view('signup-login');
});

Route::post('/create-user', [userController::class, 'create_user']);
Route::get('/create-user', function () {

    return redirect()->route('signup-login');
});

Route::post('/login', [UserController::class, 'login']);
