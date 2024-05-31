@extends('layouts.layout')
@section('styles')
    <link rel="stylesheet" href="{{ asset('/css/home.css') }}">
    <link rel="stylesheet" href="{{ asset('/css/layout.css') }}">
@endsection


@section('scripts')
    <script src="{{ asset('/js/home.js') }}"></script>
@endsection


@section('content')
    <div class="container container-fluid w-100">




        <div class="container container-fluid main">
            <div class="row main">
                <div class="col-5">
                    <div class="card">

                        <div class="card-body">
                            <h2 class="card-title col-title">Most Popular Books</h2>

                        </div>
                    </div>
                </div>


                <div class="col-5">
                    <div class="card">

                        <div class="card-body">
                            <h2 class="card-title col-title">Recently Added Books</h2>

                        </div>
                    </div>
                </div>
            </div>

            @if (!empty($popular) && !empty($recent))
                <div class="row main mt-1">
                    <div class="col-5">
                        @foreach ($popular as $book)
                            @if (isset($book))
                                @php
                                    $limiteddesc =
                                        strlen($book->description) > 100
                                            ? substr($book->description, 0, 100) . '...'
                                            : $book->description;
                                    $borrowcount = $book->borrows->count();
                                    $publisher = App\Models\Publisher::Find($book->publisher_id);
                                    $authors = $book->authors;
                                    $genres = $book->genres;
                                @endphp
                                <div class="row">

                                    <a href="/book/{{ $book->id }}">
                                        <div class="card mb-3" style="max-width: 540px;">
                                            <div class="row g-0">
                                                <div class="col-md-4">
                                                    <img src="{{ asset($book->cover_addr) }}"
                                                        class="img-fluid rounded book-cover" alt="book cover">
                                                </div>

                                                <div class="col-md-8">
                                                    <div class="card-body">
                                                        <h3 class="card-title">{{ $book->title }}</h3>
                                                        <hr>

                                                        <p class="card-text">{{ $limiteddesc }}</p>




                                                    </div>

                                                </div>
                                                <div class="card-footer text-body-secondary">
                                                    Borrowed {{ $borrowcount }} times!
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            @endif
                        @endforeach
                    </div>
                    <div class="col-5">
                        @foreach ($recent as $book)
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
                                <div class="row">

                                    <a href="/book/{{ $book->id }}">
                                        <div class="card mb-3" style="max-width: 540px;">
                                            <div class="row g-0">
                                                <div class="col-md-4">
                                                    <img src="{{ asset($book->cover_addr) }}"
                                                        class="img-fluid rounded book-cover" alt="book cover">
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
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            @else
                <div class="row">

                    <div class="col"
                        style="justify-content: center;text-align: center; min-height: 100vh; overflow: auto;">
                        <h1 class="title"
                            style="font-family: serif; font-weight: bold; font-size: 3vw;height: fit-content;padding: 5vw;color: #efe9e6;">
                            Search
                            for genres, book titles, authors or publishers to fill your feed!</h1>
                    </div>

                </div>
            @endif

        </div>

    </div>
@endsection
