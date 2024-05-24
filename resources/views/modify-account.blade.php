@extends('layouts.layout')
@section('styles')
    <link rel="stylesheet" href="{{ asset('/css/modify-account.css') }}">
    <link rel="stylesheet" href="{{ asset('/css/layout.css') }}">
@endsection


@section('scripts')
@endsection



@section('content')
    <div class="container main">

        <div class="row">
            <form action="/confirm-modify-profile" method="POST">
                @csrf



                <div class="row">
                    <div class="col-md-12">
                        <h5>Username</h5>
                        <span>Current : {{ $user->username }}</span>
                        <div class="form-group">

                            <input type="text" class="form-control" name="username" id="username"
                                placeholder="Enter your new username or leave blank...">
                            <label for="username"></label>
                        </div>

                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-12">
                        <h5>Email</h5>
                        <span>Current : {{ $user->email }}</span>
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
                        <h5>Phone Number</h5>
                        <span>Current : {{ $user->phone }}</span>
                        <div class="form-group">

                            <input type="text" class="form-control" name="phone" id="phone"
                                placeholder="Enter your new phone number or leave blank...">
                            <label for="phone"></label>
                        </div>

                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-12">
                        <h5>Address</h5>
                        <span>Current : {{ $user->adress }}</span>
                        <div class="form-group">

                            <textarea class="form-control" name="address" id="address" rows="1"
                                placeholder="Enter your new address or leave blank..."></textarea>
                            <label for="address"></label>
                        </div>

                    </div>
                </div>

                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-save" onclick="$(this).closest('form').submit();">Save</button>

                </div>
            </form>
            <div class="row">
                <div class="col-12" style="display: flex; justify-content:start;">
                    <form action="/delete-own-account" method="post">
                        @csrf
                        <button class="btn btn-delete"><i class="fas fa-trash"
                                onclick="$(this).closest('form').submit();"></i>&nbsp; Delete account</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
