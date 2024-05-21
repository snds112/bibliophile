@extends('layouts.layout')
@section('styles')
    <link rel="stylesheet" href="{{ asset('/css/add-book.css') }}">
    <link rel="stylesheet" href="{{ asset('/css/layout.css') }}">
@endsection


@section('scripts')
    <script src="{{ asset('/bootstrap/js/jquery-3.7.1.min.js') }}"></script>
@endsection



@section('content')
    <div class="container my-5">
        <div class="close-container">
            <button type="button" class="btn-close" id="closeButton" onclick="history.back()"></button>
        </div>
        <form action="/store-author" method="Post" id="book-form" enctype="multipart/form-data">
            @csrf
            <div class="row">


                <div class="col-md-12 rounded shadow p-4" style="background-color: #cfbdb4; color: black">
                    <h1>Add Author</h1>
                    <hr>
                    <div class="form-group">
                        <label for="fullname">Fullname:</label>
                        <input type="text" class="form-control" id="fullname" name="fullname">
                    </div>
                    <div class="form-group">
                        <label for="alias">Alias:</label>
                        <input type="text" class="form-control" id="alias" name="alias">
                    </div>
                    <div class="form-group my-2" id="image-upload">
                        <label for="imageInput">Select Photo Of The Author:</label>
                        <input type="file" id="images" name="image">
                    </div>

                    <button type="submit" class="btn btn-outline-commment float-end "id="store-author">Add
                        Author</button>

                </div>

            </div>
        </form>


    </div>
    </div>
@endsection
