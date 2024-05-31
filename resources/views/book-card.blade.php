@extends('layouts.layout')
@section('styles')
    <link rel="stylesheet" href="{{ asset('/css/book-card.css') }}">
    <link rel="stylesheet" href="{{ asset('/css/layout.css') }}">
@endsection


@section('scripts')
    <script src="{{ asset('/bootstrap/js/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('/js/book-card.js') }}"></script>
@endsection



@section('content')
    <div class="close-container">

        <button type="button" class="btn-close" id="closeButton" onclick="history.back()"
            style="background-color: #efe9e6"></button>
    </div>
    <div class="container  mb-5">

        <div class="row justify-content-center">

            <div class="col-md-4 mt-2">
                <div class="bookcard">

                    <div id="carouselExampleDark" class="carousel carousel-dark slide" data-bs-ride="carousel">

                        <div class="carousel-indicators">

                        </div>

                        <div class="carousel-inner">



                            <div class="carousel-item active rounded">
                                <img src="{{ asset($book->cover_addr) }}" class="d-block w-100 rounded"
                                    alt="BookCard image">
                            </div>

                        </div>


                    </div>







                </div>
            </div>

            <div class="col-md-8  mt-2">



                <div class="book-side p-2 px-4" style="border-radius: .25rem; background-color: #efe9e6;">


                    <div class="book-info py-0">
                        <div class="informations " style="margin: 10px 0px">
                            <div class="row">
                                <div class="col-md-11">
                                    @php
                                        $authors = $book->authors()->get();

                                        $publisher = $book->publisher;
                                        $genres = $book->genres;
                                    @endphp
                                    <div class="information-userinfo">
                                        <h5>Title: <span> {{ $book->title }}
                                            </span></h5>


                                        <hr>
                                        @if ($book->edition)
                                            <h5>Edition: <span> {{ $book->edition }}
                                                </span></h5>


                                            <hr>
                                        @endif

                                        <h5>Book description:</h5>
                                        <p>{!! $book->description !!}
                                        </p>


                                        <hr>
                                        <h5>Year of publication: <span> {{ $book->year_of_publication }}
                                            </span></h5>


                                        <hr>
                                        <h5>Publisher: <span> {{ $publisher->name }}
                                            </span></h5>


                                        <hr>
                                        <h5>Author(s):</h5>

                                        @foreach ($authors as $author)
                                            <span> - {{ $author->fullname }}
                                            </span>
                                        @endforeach
                                        <hr>
                                        <h5>Genre(s):</h5>

                                        @foreach ($genres as $genre)
                                            <span> - {{ $genre->name }}
                                            </span>
                                        @endforeach
                                        <br>
                                        <br>
                                        <br>
                                        <p class="text-muted mb-0">Added on
                                            {{ date('F j, Y', strtotime($book->created_at)) }}
                                        </p>
                                    </div>
                                </div>
                                <div class="col-md-1" style="text-align: end;">
                                    <div class="information-like_comment_share">
                                        <span>

                                            @if (auth()->user())
                                                <form action="/borrow/{{ auth()->user()->id }}/{{ $book->id }}"
                                                    method="post" id="borrow">
                                                    @csrf
                                                    <input type="hidden" name="bookId" value= "{{ $book->id }}">
                                                    <i class="material-symbols-outlined"
                                                        onclick="document.getElementById('borrow').submit()">book</i></button>
                                                </form>
                                            @else
                                                <form action="/signup-login}" method="get" id="login">
                                                    @csrf
                                                    <i class="material-symbols-outlined"
                                                        onclick="document.getElementById('login').submit()">book</i></button>
                                                </form>
                                            @endif

                                            <i class="material-symbols-outlined" id="copyLinkButton">send</i>
                                            <div id="copySuccess" class="visually-hidden">Link Copied!</div>
                                            <script>
                                                const copyLinkButton = document.getElementById('copyLinkButton');
                                                const linkToCopy = "https://www.example.com"; // Replace with your actual link

                                                copyLinkButton.addEventListener('click', () => {
                                                    navigator.clipboard.writeText(linkToCopy)
                                                        .then(() => {
                                                            console.log('Link copied to clipboard!');
                                                        })
                                                        .catch(err => {
                                                            console.error('Failed to copy link:', err);
                                                        });
                                                });
                                            </script>
                                            @if (auth()->user()->admin)
                                                <form action="/delete-book" method="post" id="deleteBook">
                                                    @csrf

                                                    <input type="hidden" name="bookid" value="{{ $book->id }}">
                                                    <i class="material-symbols-outlined "
                                                        onclick="document.getElementById('deleteBook').submit()">delete</i>
                                                </form>
                                                <form action="/modify-book/{{ $book->id }}" method="get"
                                                    id="modifyBook">
                                                    @csrf
                                                    <i class="material-symbols-outlined"
                                                        onclick="document.getElementById('modifyBook').submit()">
                                                        edit_document
                                                    </i>


                                                </form>
                                            @endif

                                        </span>
                                    </div>
                                </div>
                            </div>

                        </div>


                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
