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

Route::post('/store-book', [BookController::class, 'storebook']);
Route::get('/add-book', function () {
    if (auth()->user()->admin)
        return view('add-book');
    else
        return redirect()->route('home')->with('failure', 'You do not have access to that page !');
});


Route::get('/search-genre', [GenreController::class, 'searchGenres']);
Route::get('/add-author', function () {

    if (auth()->user()->admin)
        return view('add-author');
    else
        return redirect()->route('home')->with('failure', 'You do not have access to that page !');
});
Route::post('/store-author', [AuthorController::class, 'storeauthor']);
Route::get('/search-author', [AuthorController::class, 'searchAuthors']);


Route::get('/add-publisher', function () {

    if (auth()->user()->admin)
        return view('add-publisher');
    else
        return redirect()->route('home')->with('failure', 'You do not have access to that page !');
});
Route::post('/store-publisher', [PublisherController::class, 'storepublisher']);
Route::get('/add-genre', function () {

    if (auth()->user()->admin)
        return view('add-genre');
    else
        return redirect()->route('home')->with('failure', 'You do not have access to that page !');
});
Route::post('/store-genre', [GenreController::class, 'storegenre']);


Route::get('/logout', [UserController::class, 'logout']);
Route::post('/login', [UserController::class, 'login']);

route::get('/account/{username}', [userController::class, 'loadaccount'])->middleware('auth')->name('account');
route::get('/book/{book_id}', [BookController::class, 'showsinglebook'])->name('book-card');
route::get('/author/{author_id}', [AuthorController::class, 'showsingleauthor'])->name('author-card');
route::get('/genre/{genre_id}', [genreController::class, 'showsinglegenre'])->name('genre-card');
route::get('/publisher/{publisher_id}', [PublisherController::class, 'showsinglepublisher'])->name('publisher-card');

route::get('/modify-account/{username}', [userController::class, 'loadmodifyaccount'])->middleware('auth')->name('modify-account');
route::get('/modify-book/{bookId}', [BookController::class, 'loadmodifybook'])->middleware('auth')->name('modify-book');
route::get('/modify-author/{authorId}', [AuthorController::class, 'loadmodifyauthor'])->middleware('auth')->name('modify-author');
route::get('/modify-genre/{genreId}', [GenreController::class, 'loadmodifygenre'])->middleware('auth')->name('modify-genre');
route::get('/modify-publisher/{publisherId}', [publisherController::class, 'loadmodifypublisher'])->middleware('auth')->name('modify-publisher');

Route::post('/confirm-modify-profile', [UserController::class, 'modifyaccount']);
Route::post('/confirm-modify-book', [BookController::class, 'modifybook']);
Route::post('/confirm-modify-author', [AuthorController::class, 'modifyauthor']);
Route::post('/confirm-modify-genre', [GenreController::class, 'modifygenre']);
Route::post('/confirm-modify-publisher', [publisherController::class, 'modifypublisher']);

Route::post('/delete-account', [UserController::class, 'deleteaccount']);
Route::post('/delete-book', [BookController::class, 'deletebook']);
Route::post('/delete-author', [AuthorController::class, 'deleteauthor']);
Route::post('/delete-genre', [GenreController::class, 'deletegenre']);
Route::post('/delete-publisher', [publisherController::class, 'deletepublisher']);



Route::post('/search', [UserController::class, 'searchResults']);
Route::post('/confirm-request', [BookController::class, 'confirmRequest']);
Route::post('/delete-request', [BookController::class, 'deleteRequest']);
route::post('/borrow/{user_id}/{book_id}', [BookController::class, 'borrow']);
Route::post('/return-book', [BookController::class, 'returnBook']);
Route::post('/request-admin', [UserController::class, 'requestadmin']);
