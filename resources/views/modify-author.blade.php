@extends('layouts.layout')
@section('styles')
    <link rel="stylesheet" href="{{ asset('/css/modify-account.css') }}">
    <link rel="stylesheet" href="{{ asset('/css/layout.css') }}">
@endsection


@section('scripts')
    <script src="{{ asset('/bootstrap/js/jquery-3.7.1.min.js') }}"></script>
@endsection



@section('content')
    <div class="container main my-5">

        <div class="row">

            <form action="/confirm-modify-author" method="Post" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="authorid" value="{{ $author->id }}">



                <div class="row mb-4 ">
                    <div class="col-md-12">

                        <h5>Photo</h5>
                        <div class="row d-flex" style="justify-content: start">
                            <div class="cover-side">

                                <img src="{{ $author->photo_addr }}" alt="Current Cover Photo" class="current-cover">
                            </div>
                            <div class="choose-side d-flex" style="align-items: center">
                                <input type="file" name="photo" class="form-control-file">

                            </div>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="form-group">
                    <label for="fullname">
                        <h5>Fullname:</h5>
                    </label><br>
                    <span>Current : {{ $author->fullname }}</span>
                    <input type="text" class="form-control" id="fullname" name="fullname"
                        placeholder="Enter new full name or leave blank...">
                </div>
                <hr>
                <div class="form-group">
                    <label for="alias">
                        <h5>Alias:</h5>
                    </label><br>
                    <span>Current : {{ $author->alias }}</span>
                    <input type="text" class="form-control" id="alias" name="alias"
                        placeholder="Enter new alias or leave blank...">
                </div>
                <hr>
                <div class="form-group">
                    <label for="alias">
                        <h5>Biography:</h5>
                    </label><br>
                    <span>Current : <br>{{ $author->bio }}</span>
                    <textarea class="form-control" name="biography" id="biography" rows="1"
                        placeholder="Enter new biography or leave blank..."></textarea>
                    <label for="biography"></label>
                </div>
                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-save" onclick="$(this).closest('form').submit();">Save</button>

                </div>



            </form>
            <div class="row">
                <div class="col-12" style="display: flex; justify-content:start;">
                    <form action="/delete-author" method="post">
                        @csrf
                        <input type="hidden" name="id" value="{{ $author->id }}">
                        <button class="btn btn-delete"><i class="fas fa-trash"
                                onclick="$(this).closest('form').submit();"></i>&nbsp; Delete author</button>
                    </form>
                </div>
            </div>


        </div>
    </div>
@endsection
