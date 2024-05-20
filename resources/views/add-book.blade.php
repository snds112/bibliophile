@extends('layouts.layout')
@section('styles')
    <link rel="stylesheet" href="{{ asset('/css/add-book.css') }}">
    <link rel="stylesheet" href="{{ asset('/css/layout.css') }}">
@endsection


@section('scripts')
    <script src="{{ asset('/bootstrap/js/jquery-3.7.1.min.js') }}"></script>

    <script src="{{ asset('/js/add-book.js') }}"></script>
@endsection



@section('content')
    <div class="container my-5">
        <div class="close-container">
            <button type="button" class="btn-close" id="closeButton" onclick="history.back()"></button>
        </div>
        <form action="/store-book" method="Post" id="book-form" enctype="multipart/form-data">
            @csrf
            <div class="row">


                <div class="col-md-12 rounded shadow p-4" style="background-color: #cfbdb4; color: black">
                    <h1>Add Book</h1>
                    <hr>
                    <div class="form-group">
                        <label for="ISBN">ISBN:</label>
                        <input type="text" class="form-control" id="ISBN" name="ISBN">
                    </div>
                    <div class="form-group">
                        <label for="title">Title:</label>
                        <input type="text" class="form-control" id="title" name="title">
                    </div>
                    <div class="form-group">
                        <label for="year_of_publication">Year Of Publication:</label>
                        <input type="text" class="form-control" id="year_of_publication" name="year_of_publication">
                    </div>
                    <div class="form-group">
                        <label for="edition">Edition:</label>
                        <input type="text" class="form-control" id="edition" name="edition">
                    </div>
                    <div class="form-group">
                        <label for="type">book Type:</label>
                        <select class="form-control" id="type" name="type">
                            <option value="Hardcover">Hardcover</option>
                            <option value="Paperback">Paperback</option>
                            <option value="Ebook">Ebook</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="description">Book description:</label>
                        <textarea class="form-control" id="description" name="description" rows="5"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="number_of_copies">Number Of Copies:</label>
                        <input type="text" class="form-control" id="number_of_copies" name="number_of_copies">
                    </div>

                    <div class="form-group">
                        <label for="publisher">Name Of The Publisher:</label>
                        <input type="text" class="form-control" id="publisher" name="publisher">
                    </div>

                    <div class="form-group my-2" id="image-upload">
                        <label for="imageInput">Select Cover Image:</label>
                        <input type="file" id="images" name="image">
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">

                                <label for="searchPeople">Search Genres :</label>
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

                                {{-- <label for="searchPeople">Search Authors:</label>
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" id="author-name" name="author-name"
                                        placeholder="Search for genres">
                                    <button class="btn btn-outline-secondary" type="button" name="add-genre"
                                        id="add-genre">Add</button>
                                    <button class="btn btn-outline-secondary" type="button"
                                        name="reset-genre"id="reset-genre">Reset</button>

                                </div>
                                <div id="genre-message"></div>
                                <ul id="selected-genres"></ul>
                                <input type="hidden" name="genres" id="genres" value="">
 --}}
                            </div>
                        </div>
                    </div>
                    <button class="btn btn-outline-commment float-end "id="store-book">Add
                        Book</button>

                </div>

            </div>
        </form>


    </div>
    </div>
@endsection
