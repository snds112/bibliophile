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
        <form action="/store-publisher" method="Post" id="book-form" enctype="multipart/form-data">
            @csrf
            <div class="row">


                <div class="col-md-12 rounded shadow p-4" style="background-color: #cfbdb4; color: black">
                    <h1>Add Publisher</h1>
                    <hr>
                    <div class="form-group">
                        <label for="name">Name:</label>
                        <input type="text" class="form-control" id="name" name="name">
                    </div>
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="text" class="form-control" id="email" name="email">
                    </div>
                    <div class="form-group">
                        <label for="phone">Phone:</label>
                        <input type="text" class="form-control" id="phone" name="phone">
                    </div>


                    <button type="submit" class="btn btn-outline-commment float-end "id="store-publisher">Add
                        Publisher</button>

                </div>

            </div>
        </form>


    </div>
    </div>
@endsection
