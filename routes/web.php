<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\PublisherController;
use App\Models\Book;



Route::get('/', [BookController::class, 'loadhome'])->name('home');

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


Route::get('/add-book', function () {
    if (auth()->user()->admin)
        return view('add-book');
    else
        return redirect()->route('home')->with('failure', 'You do not have access to that page !');
})->middleware('auth');
Route::get('/add-author', function () {

    if (auth()->user()->admin)
        return view('add-author');
    else
        return redirect()->route('home')->with('failure', 'You do not have access to that page !');
})->middleware('auth');
Route::get('/add-publisher', function () {

    if (auth()->user()->admin)
        return view('add-publisher');
    else
        return redirect()->route('home')->with('failure', 'You do not have access to that page !');
})->middleware('auth');
Route::get('/add-genre', function () {
    if (auth()->user()->admin) {
        return view('add-genre');
    } else {
        return redirect()->route('home')->with('failure', 'You do not have access to that page !');
    }
})->middleware('auth');

Route::get('/search-author', [AuthorController::class, 'searchAuthors']);
Route::get('/search-genre', [GenreController::class, 'searchGenres']);

Route::post('/store-book', [BookController::class, 'storebook'])->middleware('auth');
Route::post('/store-author', [AuthorController::class, 'storeauthor'])->middleware('auth');
Route::post('/store-publisher', [PublisherController::class, 'storepublisher'])->middleware('auth');
Route::post('/store-genre', [GenreController::class, 'storegenre'])->middleware('auth');

Route::get('/logout', [UserController::class, 'logout'])->middleware('auth');
Route::post('/login', [UserController::class, 'login']);
Route::post('/request-admin', [UserController::class, 'requestadmin'])->middleware('auth');

Route::post('/search', [UserController::class, 'searchResults']);
route::get('/account/{username}', [userController::class, 'loadaccount'])->middleware('auth')->name('account');
route::get('/book/{book_id}', [BookController::class, 'showsinglebook'])->middleware('auth')->name('book-card');
route::get('/author/{author_id}', [AuthorController::class, 'showsingleauthor'])->middleware('auth')->name('author-card');
route::get('/genre/{genre_id}', [genreController::class, 'showsinglegenre'])->middleware('auth')->name('genre-card');
route::get('/publisher/{publisher_id}', [PublisherController::class, 'showsinglepublisher'])->middleware('auth')->name('publisher-card');

route::get('/modify-account/{username}', [userController::class, 'loadmodifyaccount'])->middleware('auth')->name('modify-account');
route::get('/modify-book/{bookId}', [BookController::class, 'loadmodifybook'])->middleware('auth')->name('modify-book');
route::get('/modify-author/{authorId}', [AuthorController::class, 'loadmodifyauthor'])->middleware('auth')->name('modify-author');
route::get('/modify-genre/{genreId}', [GenreController::class, 'loadmodifygenre'])->middleware('auth')->name('modify-genre');
route::get('/modify-publisher/{publisherId}', [publisherController::class, 'loadmodifypublisher'])->middleware('auth')->name('modify-publisher');

Route::post('/confirm-modify-profile', [UserController::class, 'modifyaccount'])->middleware('auth');
Route::post('/confirm-modify-book', [BookController::class, 'modifybook'])->middleware('auth');
Route::post('/confirm-modify-author', [AuthorController::class, 'modifyauthor'])->middleware('auth');
Route::post('/confirm-modify-genre', [GenreController::class, 'modifygenre'])->middleware('auth');
Route::post('/confirm-modify-publisher', [publisherController::class, 'modifypublisher'])->middleware('auth');

Route::post('/delete-account', [UserController::class, 'deleteaccount'])->middleware('auth');
Route::post('/delete-book', [BookController::class, 'deletebook'])->middleware('auth');
Route::post('/delete-author', [AuthorController::class, 'deleteauthor'])->middleware('auth');
Route::post('/delete-genre', [GenreController::class, 'deletegenre'])->middleware('auth');
Route::post('/delete-publisher', [publisherController::class, 'deletepublisher'])->middleware('auth');


Route::post('/confirm-request', [BookController::class, 'confirmRequest'])->middleware('auth');
Route::post('/delete-request', [BookController::class, 'deleteRequest'])->middleware('auth');
route::post('/borrow/{user_id}/{book_id}', [BookController::class, 'borrow'])->middleware('auth');
Route::post('/return-book', [BookController::class, 'returnBook'])->middleware('auth');
