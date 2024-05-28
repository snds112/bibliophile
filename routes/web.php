<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\PublisherController;
use App\Models\Book;



Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/signup-login', function () {

    return view('signup-login');
})->name('signup-login');
Route::get('/signup-login', function () {

    return view('signup-login');
})->name('login');
Route::post('/create-user', [UserController::class, 'create_user']);
Route::get('/create-user', function () {

    return redirect()->route('signup-login');
});

Route::post('/store-book', [BookController::class, 'storebook']);
Route::get('/add-book', function () {

    return view('add-book');
});
Route::get('/search-genre', [GenreController::class, 'searchGenres']);
Route::get('/add-author', function () {

    return view('add-author');
});
Route::post('/store-author', [AuthorController::class, 'storeauthor']);
Route::get('/add-publisher', function () {

    return view('add-publisher');
});
Route::post('/store-publisher', [PublisherController::class, 'storepublisher']);
Route::get('/add-genre', function () {

    return view('add-genre');
});

route::get('/book/{book_id}', [BookController::class, 'showsinglebook'])->name('book-card');
route::post('/borrow/{user_id}/{book_id}', [BookController::class, 'checkborrow']);
Route::post('/store-genre', [GenreController::class, 'storegenre']);
Route::get('/search-author', [AuthorController::class, 'searchAuthors']);
Route::get('/logout', [UserController::class, 'logout']);
Route::post('/login', [UserController::class, 'login']);
route::get('/account/{username}', [userController::class, 'loadaccount'])->middleware('auth')->name('account');
route::get('/modify-account/{username}', [userController::class, 'loadmodifyaccount'])->middleware('auth')->name('modify-account');
route::get('/modify-book/{bookId}', [BookController::class, 'loadmodifybook'])->middleware('auth')->name('modify-book');

Route::post('/confirm-modify-profile', [UserController::class, 'modifyaccount']);
Route::post('/confirm-modify-book', [BookController::class, 'modifybook']);
Route::post('/request-admin', [UserController::class, 'requestadmin']);
Route::post('/delete-account', [UserController::class, 'deleteaccount']);
Route::post('/delete-book', [BookController::class, 'deletebook']);
