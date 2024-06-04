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
            <form action="/confirm-modify-publisher" method="POST">
                @csrf


                <input type="hidden" name="publisherid" value="{{ $publisher->id }}">
                <div class="row">
                    <div class="col-md-12">
                        <h5>Name</h5>
                        <span>Current : {{ $publisher->name }}</span>
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
                        <h5>Email</h5>
                        <span>Current : {{ $publisher->email }}</span>
                        <div class="form-group">

                            <input type="text" class="form-control" name="email" id="email"
                                placeholder="Enter your new email or leave blank...">
                            <label for="email"></label>
                        </div>

                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-12">
                        <h5>Phone</h5>
                        <span>Current : {{ $publisher->phone }}</span>
                        <div class="form-group">

                            <input type="text" class="form-control" name="phone" id="phone"
                                placeholder="Enter your new phone or leave blank...">
                            <label for="phone"></label>
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
                    <form action="/delete-publisher" method="post">
                        @csrf
                        <input type="hidden" name="id" value="{{ $publisher->id }}">
                        <button class="btn btn-delete"><i class="fas fa-trash"
                                onclick="$(this).closest('form').submit();"></i>&nbsp; Delete Publisher</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
