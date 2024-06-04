@extends('layouts.layout')
@section('styles')
    <link rel="stylesheet" href="{{ asset('/css/modify-account.css') }}">
    <link rel="stylesheet" href="{{ asset('/css/layout.css') }}">
@endsection


@section('scripts')
@endsection



@section('content')
    <div class="container main my-5">

        <div class="row">
            <form action="/confirm-modify-genre" method="POST">
                @csrf


                <input type="hidden" name="genreid" value="{{ $genre->id }}">
                <div class="row">
                    <div class="col-md-12">
                        <h5>Name</h5>
                        <span>Current : {{ $genre->name }}</span>
                        <div class="form-group">

                            <input type="text" class="form-control" name="name" id="name"
                                placeholder="Enter your new name or leave blank...">
                            <label for="name"></label>
                        </div>

                    </div>
                </div>

                <hr>
                <div class="row">
                    <div class="col-md-12">
                        <h5>Description</h5>
                        <span>Current : {{ $genre->description }}</span>
                        <div class="form-group">

                            <textarea class="form-control" name="description" id="description" rows="1"
                                placeholder="Enter your new description or leave blank..."></textarea>
                            <label for="description"></label>
                        </div>

                    </div>
                </div>
                <hr>


                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-save" onclick="$(this).closest('form').submit();">Save</button>

                </div>
            </form>
            <div class="row">
                <div class="col-12" style="display: flex; justify-content:start;">
                    <form action="/delete-genre" method="post">
                        @csrf
                        <input type="hidden" name="id" value="{{ $genre->id }}">
                        <button class="btn btn-delete"><i class="fas fa-trash"
                                onclick="$(this).closest('form').submit();"></i>&nbsp; Delete Genre</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
