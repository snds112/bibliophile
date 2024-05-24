@extends('layouts.layout')
@section('styles')
    <link rel="stylesheet" href="{{ asset('/css/view-account.css') }}">
    <link rel="stylesheet" href="{{ asset('/css/layout.css') }}">
@endsection


@section('scripts')
    <script src="{{ asset('/js/view-account.js') }}"></script>
@endsection


@section('content')
    <div class="container">
        <div class="row  d-flex flex-wrap mb-5" style="justify-content: center">
            <div class=" col-md-4 d-flex ">
                <div class="user-info-container-col p-5 rounded ">
                    <h3 class="user-info-title">User Information :</h3>
                    <div class="user-info-list">
                        <br>
                        <span class="user-info-label">Username:</span>
                        <span class="user-info-value">{{ $user->username }}</span>
                        <hr>

                        <span class="user-info-label">Email:</span>
                        <span class="user-info-value">{{ $user->email }}</span>
                        <hr>

                        <span class="user-info-label">Phone:</span>
                        <span class="user-info-value">{{ $user->phone }}</span>
                        <hr>

                        <span class="user-info-label">Address:</span>
                        <span class="user-info-value">{{ $user->adress }}</span>
                        <hr>
                        <div class="user-info-label-admin d-flex" style="justify-content: space-between">
                            <div>
                                <span class="user-info-label">Admin:</span>
                                <span class="user-info-value">
                                    @if ($user->admin)
                                        &nbsp;Yes
                                    @else
                                        &nbsp;No
                                    @endif

                                </span>
                            </div>
                            @if (!$user->admin || auth()->user()->id === $user->id)
                                <form action="/request-admin" method="post">
                                    @csrf
                                    <input type="hidden" name="username" value="{{ $user->username }}">
                                    <button type="submit" class="btn ">Request Admin Status</button>
                                </form>
                            @endif
                        </div>
                        <hr>
                    </div>

                    <div class="user-info-actions">
                        <a href="/modify-account/{{ $user->username }}" class="btn  btn-modify">Modify
                            Information</a>

                    </div>
                </div>
            </div>
            <div class="col-md-6  rounded">
                <div class="container user-borrow-info-col rounded">
                    @foreach ($activeBorrows as $borrow)
                        <a href="/book/{{ $borrow->id }}" style="color: black">
                            @php
                                $book = $borrow->copy->book;
                                $limiteddesc =
                                    strlen($book->description) > 20
                                        ? substr($book->description, 0, 40) . '...'
                                        : $book->description;
                            @endphp
                            <div class=" row borrow-item">
                                <div class="col-3 book-cover-col"><img src="{{ $book->cover_addr }}" alt="Book Cover"
                                        class="bc"></div>
                                <div class="col-9 book-info-col">
                                    <span>Title: {{ $book->title }}</span>
                                    <br>
                                    <span> Description: <span class="text-muted">{{ $limiteddesc }}</span></span>
                                    <br>
                                    <span>Borrowed on:</span>
                                    <span>{{ $borrow->created_at->format('d/m/Y') }}</span>
                                    <br>
                                    @if ($borrow->returned_at)
                                        <span>Returned on:</span>
                                        <span>{{ $borrow->returned_at }}</span>
                                    @else
                                        <span>Not returned yet...</span>
                                    @endif
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>



            </div>
        </div>
    </div>
@endsection
