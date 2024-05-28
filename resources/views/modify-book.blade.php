@extends('layouts.layout')
@section('styles')
    <link rel="stylesheet" href="{{ asset('/css/modify-account.css') }}">
    <link rel="stylesheet" href="{{ asset('/css/layout.css') }}">
@endsection


@section('scripts')
    <script src="{{ asset('/bootstrap/js/jquery-3.7.1.min.js') }}"></script>

    <script src="{{ asset('/js/add-book.js') }}"></script>
@endsection



@section('content')
    <div class="container main my-5">

        <div class="row">
            <form action="/confirm-modify-book" method="POST" id="book-form"enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="bookid" value="{{ $book->id }}">
                <div class="row mb-4 ">
                    <div class="col-md-12">

                        <h5>Cover</h5>
                        <div class="row d-flex" style="justify-content: start">
                            <div class="cover-side">

                                <img src="{{ $book->cover_addr }}" alt="Current Cover Photo" class="current-cover">
                            </div>
                            <div class="choose-side d-flex" style="align-items: center">
                                <input type="file" name="cover" class="form-control-file">

                            </div>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-12">
                        <h5>ISBN</h5>
                        <span>Current : {{ $book->ISBN }}</span>
                        <div class="form-group">

                            <input type="text" class="form-control" name="ISBN" id="ISBN"
                                placeholder="Enter new ISBN or leave blank...">
                            <label for="ISBN"></label>
                        </div>

                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-12">
                        <h5>Title</h5>
                        <span>Current : {{ $book->title }}</span>
                        <div class="form-group">

                            <input type="text" class="form-control" name="title" id="title"
                                placeholder="Enter new title or leave blank...">
                            <label for="title"></label>
                        </div>

                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-12">
                        <h5>Year Of Publication</h5>
                        <span>Current : {{ $book->year_of_publication }}</span>
                        <div class="form-group">

                            <input type="text" class="form-control" name="year_of_publication" id="year_of_publication"
                                placeholder="Enter new year of publication or leave blank...">
                            <label for="year_of_publication"></label>
                        </div>

                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-12">
                        <h5>Edition</h5>
                        <span>Current : {{ $book->edition }}</span>
                        <div class="form-group">

                            <input type="text" class="form-control" name="edition" id="edition"
                                placeholder="Enter new edition or leave blank...">
                            <label for="edition"></label>
                        </div>

                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-12">
                        <h5>Description</h5>
                        <span>Current : {!! $book->description !!}</span>
                        <div class="form-group">

                            <textarea class="form-control" name="description" id="description" rows="1"
                                placeholder="Enter new description or leave blank..."></textarea>
                            <label for="description"></label>
                        </div>

                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-12">
                        <h5>Type</h5>
                        <span>Current : {{ $book->type }}</span>
                        <div class="form-group">
                            <select class="form-control" id="type" name="type">
                                <option value="Hardcover" @if ($book->type === 'Hardcover') selected @endif>Hardcover
                                </option>
                                <option value="Paperback" @if ($book->type === 'Paperback') selected @endif>Paperback
                                </option>
                                <option value="Ebook" @if ($book->type === 'Ebook') selected @endif>Ebook</option>
                            </select>
                        </div>

                    </div>
                </div>
                <hr>

                <div class="row">
                    <div class="col-md-12">
                        <h5>Add copies</h5>
                        <span>Current : {{ $book->number_of_copies }}</span>
                        <div class="form-group">

                            <input type="text" class="form-control" name="number_of_copies" id="number_of_copies"
                                placeholder="Enter new number of copies or leave blank...">
                            <label for="number_of_copies"></label>
                        </div>

                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-12">
                        <h5>Publisher</h5>
                        @php
                            $publisher = App\Models\Publisher::Find($book->publisher_id)
                                ->get()
                                ->first();
                        @endphp
                        <span>Current : {{ $publisher->name }}</span>
                        <div class="form-group">

                            <input type="text" class="form-control" name="publisher_id" id="publisher_id"
                                placeholder="Enter new publisher or leave blank...">
                            <label for="publisher_id"></label>
                            <a href="/add-publisher" style="text-decoration: underline; color: black;">Add Publisher?</a>
                        </div>

                    </div>

                </div>
                <hr>
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">

                            <h5>Genres</h5>

                            <span>Input a new list of genres or leave blank to keep the current genres :</span>
                            <br>
                            @foreach ($book->genres as $genre)
                                <span>- {{ $genre->name }}</span>
                            @endforeach
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" id="genre-name" name="genre-name"
                                    placeholder="Search for genres">
                                <button class="btn btn-outline-secondary" type="button" name="add-genre"
                                    id="add-genre">Add</button>
                                <button class="btn btn-outline-secondary" type="button"
                                    name="reset-genre"id="reset-genre">Reset</button>

                            </div>
                            <div id="genre-message"></div>
                            <ul id="selected-genres"></ul>
                            <input type="hidden" name="genres" id="genres" value="">

                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">


                            <h5>Authors</h5>

                            <span>Input a new list of authors or leave blank to keep the current authors :</span>
                            <br>
                            @foreach ($book->authors as $author)
                                <span>- {{ $author->fullname }}</span>
                            @endforeach
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" id="author-name" name="author-name"
                                    placeholder="Search for authors">
                                <button class="btn btn-outline-secondary" type="button" name="add-author"
                                    id="add-author">Add</button>
                                <button class="btn btn-outline-secondary" type="button"
                                    name="reset-author"id="reset-author">Reset</button>

                            </div>
                            <div id="author-message"></div>
                            <ul id="selected-authors"></ul>
                            <input type="hidden" name="authors" id="authors" value="">

                        </div>
                    </div>
                </div>
                <hr>
                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-save" id="store-book">Save</button>

                </div>
            </form>
            <div class="row">
                <div class="col-12" style="display: flex; justify-content:start;">
                    <form action="/delete-book" method="post">
                        @csrf
                        <input type="hidden" name="id" value="{{ $book->id }}">
                        <button class="btn btn-delete"><i class="fas fa-trash"
                                onclick="$(this).closest('form').submit();"></i>&nbsp; Delete Book</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
