@extends('layouts.layout')
@section('styles')
    <link rel="stylesheet" href="{{ asset('/css/view-account.css') }}">
    <link rel="stylesheet" href="{{ asset('/css/home.css') }}">

    <link rel="stylesheet" href="{{ asset('/css/layout.css') }}">
@endsection


@section('scripts')
    <script src="{{ asset('/js/view-account.js') }}"></script>
@endsection


@section('content')
    <div class="container" style="min-width: 90%">
        <div class="row  d-flex flex-wrap mb-5" style="justify-content: center">
            <div class=" col-md-4 d-flex ">
                <div class="user-info-container-col p-5 rounded ">
                    <div class=" row profile-image">

                        <div class="card mb-3" style="border: 0px;">
                            <div class="row g-0">
                                <div class="col-md-4 " style="align-content: center">
                                    <img src="{{ asset($author->photo_addr) }}" class="img-fluid rounded book-cover"
                                        alt="author photo">
                                </div>

                                <div class="col-md-8">
                                    <div class="card-body">
                                        <h3 class="card-title">Author information:</h3>





                                    </div>

                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="user-info-list">
                        <br>
                        <span class="user-info-label">Full Name:</span>
                        <span class="user-info-value">{{ $author->fullname }}</span>
                        <hr>

                        <span class="user-info-label">Alias:</span>
                        <span class="user-info-value">{{ $author->alias }}</span>
                        <hr>

                        <span class="user-info-label">Biography:</span>
                        <p class="user-info-value">{{ $author->bio }}</p>
                        <hr>



                        <div class="user-info-label-admin d-flex" style="justify-content: center">

                            @if (auth()->user()->admin)
                                <form action="/modify-author/{{ $author->id }}" method="get">
                                    @csrf

                                    <button type="submit" class="btn "
                                        onclick="event.preventDefault(); $(this).closest('form').submit();">Modify</button>
                                </form>
                            @endif
                        </div>

                    </div>


                </div>
            </div>
            <div class="col-md-4">
                <div class="card mb-3" style="width: 30rem; height: auto">
                    <div class="row g-0">


                        <div class="col-md-12">
                            <div class="card-body">
                                <h1 class="card-title text-center">Books by this author</h1>





                            </div>

                        </div>

                    </div>
                </div>
                @php
                    $books = $author->books;
                @endphp
                @foreach ($books as $book)
                    @if (isset($book))
                        @php
                            $limiteddesc =
                                strlen($book->description) > 100
                                    ? substr($book->description, 0, 100) . '...'
                                    : $book->description;
                            $date = $book->created_at;
                            $publisher = App\Models\Publisher::Find($book->publisher_id);
                            $authors = $book->authors;
                            $genres = $book->genres;
                        @endphp


                        <a href="/book/{{ $book->id }}" style="text-decoration: none">
                            <div class="card mb-3" style="width: 30rem; height: auto">
                                <div class="row g-0">
                                    <div class="col-md-4">
                                        <img src="{{ asset($book->cover_addr) }}" class="img-fluid rounded book-cover"
                                            alt="book cover">
                                    </div>

                                    <div class="col-md-8">
                                        <div class="card-body">
                                            <h3 class="card-title">{{ $book->title }}</h3>
                                            <hr>

                                            <p class="card-text">{{ $limiteddesc }}</p>




                                        </div>

                                    </div>
                                    <div class="card-footer text-body-secondary">
                                        Added on {{ date('F j, Y', strtotime($date)) }}.
                                    </div>
                                </div>
                            </div>
                        </a>
                    @endif
                @endforeach

            </div>
        </div>
    </div>
@endsection
