@extends('layouts.layout')
@section('styles')
    <link rel="stylesheet" href="{{ asset('/css/home.css') }}">
    <link rel="stylesheet" href="{{ asset('/css/layout.css') }}">
@endsection


@section('scripts')
    <script src="{{ asset('/js/home.js') }}"></script>
@endsection


@section('content')
    <div class="container container-fluid" style="min-width: 100%">




        <div class="container container-fluid main" style="min-width: 100%">
            <div class="row main">
                <div class="col-2">
                    <div class="card" style="border: #896858; background-color: #896858">

                        <div class="card-body">
                            <h4 class="card-title col-title" style="color: #efe9e6">Users</h4>

                        </div>
                    </div>
                </div>


                <div class="col-2">
                    <div class="card" style="border: #896858; background-color: #896858">

                        <div class="card-body">
                            <h4 class="card-title col-title" style="color: #efe9e6">Authors</h4>

                        </div>
                    </div>
                </div>
                <div class="col-2">
                    <div class="card" style="border: #896858; background-color: #896858">

                        <div class="card-body">
                            <h4 class="card-title col-title" style="color: #efe9e6">Publishers</h4>

                        </div>
                    </div>
                </div>
                <div class="col-2">
                    <div class="card" style="border: #896858; background-color: #896858">

                        <div class="card-body">
                            <h4 class="card-title col-title" style="color: #efe9e6">Genres</h4>

                        </div>
                    </div>
                </div>
                <div class="col-2">
                    <div class="card" style="border: #896858; background-color: #896858">

                        <div class="card-body">
                            <h4 class="card-title col-title" style="color: #efe9e6">Books</h4>

                        </div>
                    </div>
                </div>
            </div>

            @if (!empty($results))
                <div class="row main mt-1">
                    <div class="col-2">

                        @foreach ($results[0] as $user)
                            @if (isset($user))
                                <div class="row">

                                    <a href="/account/{{ $user->username }}">
                                        <div class="card mt-3" style="max-width: 540px;">
                                            <div class="row g-0">


                                                <div class="col-md-12">
                                                    <div class="card-body text-center">
                                                        <h5 class="card-title">{{ $user->username }}</h5>





                                                    </div>

                                                </div>

                                            </div>
                                        </div>
                                    </a>
                                </div>
                            @endif
                        @endforeach
                    </div>
                    <div class="col-2">
                        @foreach ($results[1] as $author)
                            @if (isset($author))
                                @php
                                    $books = $author->books;
                                @endphp
                                @if (count($books) > 0)
                                    <div class="card mt-3 mb-1" style="background-color: #cfbdb4; border:#cfbdb4;">
                                        <div class="row g-0">
                                            <div class="col-md-12">
                                                <div class="card-body text-center">
                                                    <h5 class="card-title">{{ $author->fullname }}</h5>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @foreach ($books as $book)
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
                                                    <div class="card mb-1" style="max-width: 540px;">
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

                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                        @endif
                                    @endforeach
                                @endif
                            @endif
                        @endforeach
                    </div>
                    <div class="col-2">
                        @foreach ($results[2] as $publisher)
                            @if (isset($publisher))
                                @php
                                    $books = $publisher->books;
                                @endphp
                                @if (count($books) > 0)
                                    <div class="card mt-3 mb-1" style="background-color: #cfbdb4; border:#cfbdb4;">
                                        <div class="row g-0">
                                            <div class="col-md-12">
                                                <div class="card-body text-center">
                                                    <h5 class="card-title">{{ $publisher->name }}</h5>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    @foreach ($books as $book)
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
                                                    <div class="card mb-1" style="max-width: 540px;">
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

                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                        @endif
                                    @endforeach
                                @endif
                            @endif
                        @endforeach
                    </div>
                    <div class="col-2">
                        @foreach ($results[3] as $genre)
                            @if (isset($genre))
                                @php
                                    $books = $genre->books;
                                @endphp
                                @if (count($books) > 0)
                                    <div class="card mt-3 mb-1" style="background-color: #cfbdb4; border:#cfbdb4;">
                                        <div class="row g-0">
                                            <div class="col-md-12">
                                                <div class="card-body text-center">
                                                    <h5 class="card-title">{{ $genre->name }}</h5>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    @foreach ($books as $book)
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
                                                    <div class="card mb-1" style="max-width: 540px;">
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

                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                        @endif
                                    @endforeach
                                @endif
                            @endif
                        @endforeach
                    </div>
                    <div class="col-2">
                        @foreach ($results[4] as $book)
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
                                        <div class="card mt-3 " style="max-width: 540px;">
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
