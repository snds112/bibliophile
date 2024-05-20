@extends('layouts.layout')
@section('styles')
    <link rel="stylesheet" href="{{ asset('/css/home.css') }}">
    <link rel="stylesheet" href="{{ asset('/css/layout.css') }}">
@endsection


@section('scripts')
    <script src="{{ asset('/js/home.js') }}"></script>
@endsection


@section('content')
    @php
        $pagenum = 0;
    @endphp
    <div class="container container-fluid w-100">




        <div class="container container-fluid main">
            @if (!empty($books))
                <div class="row ">

                    {{-- <div class="col-md-2 col-sm-3">
                    <form action="/filter-home-page" method="GET" class="category-form">
                        @php
                            //add genres
                        @endphp
                        <ul class="category-list">

                            @foreach ($categories as $category)
                                <li>
                                    <button type="submit" name="category" value="{{ $category }}"
                                        style="font-family:
                                    serif;  font-size: 1rem;">
                                        {{ ucfirst($category) }} </button>
                                </li>
                            @endforeach
                        </ul>
                    </form>
                        </div> --}}
                    <div class="col-md-10 col-sm-9 books">
                        @if (!empty($books))
                            <div class="row">



                                @php
                                    $chunkSize = ceil(count($books) / 4); // Round up to ensure at least 2 elements per chunk
                                    $numChunks = min(count($books), 4); // Limit to 3 chunks (avoid creating empty chunks)
                                    $chunks = array_fill(0, $numChunks, []); // Initialize empty chunks

                                    $i = 0;
                                    foreach ($books as $book) {
                                        $chunks[$i % $numChunks][] = $book; // Distribute elements round-robin
                                        $i++;
                                    }

                                @endphp
                                @foreach ($chunks as $chunk)
                                    @if (isset($chunk))
                                        <div class="col-lg-3 col-md-4 col-sm-6 post-column">
                                            <div class="row row-cols-1 g-2">
                                                @foreach ($chunk as $book)
                                                    @if (isset($book))
                                                        {{--  <div class="col">

                                                        <a
                                                            href="/post/{{ $post->accounts[0]->username }}/{{ $post->id }}">
                                                            <div class="card">
                                                                @php

                                                                    foreach ($post->media as $media) {
                                                                        if ($media->type == 'image') {
                                                                            $image = $media;
                                                                            break;
                                                                        }
                                                                    }
                                                                    $limitedCaption =
                                                                        strlen($post->caption) > 40
                                                                            ? substr($post->caption, 0, 40) . '...'
                                                                            : $post->caption;
                                                                @endphp
                                                                <div class="image-container">
                                                                    <img class="card-img-top"
                                                                        src="{{ asset($image->addr) }}"
                                                                        alt="Card image cap">
                                                                    @if ($post->type == 'video' || $post->type == 'audio')
                                                                        <div class="card-img-overlay">
                                                                            <span
                                                                                class="material-symbols-outlined play-button"
                                                                                style="font-size: 3rem">
                                                                                play_arrow
                                                                            </span>
                                                                        </div>
                                                                    @endif
                                                                </div>
                                                                <div class="card-body">
                                                                    <div class="information-userinfo">

                                                                        <span> <img
                                                                                src="{{ asset($post->accounts[0]->avatar) }}"
                                                                                alt="User's Profile Picture"
                                                                                style="width: 1.5rem; height: 1.5rem; border-radius: 50%;">
                                                                            <a class="mr-2 profile-link"
                                                                                href="/profile/{{ $post->accounts[0]->username }}">{{ $post->accounts[0]->username }}</a>
                                                                        </span>

                                                                        <p class="text-muted"
                                                                            style="font-size: 0.6rem;
                                                                        margin: 0.30rem;">
                                                                            {{ date('F j, Y', strtotime($post->created_at)) }}
                                                                        </p>

                                                                    </div>
                                                                    <div class="likebutton" style="margin-left: auto">
                                                                        @php
                                                                            $post = App\Models\Post::find($post->id);
                                                                            $likes = $post->likes;
                                                                            $user = App\Models\Account::find(
                                                                                auth()->user()->id,
                                                                            );
                                                                            $hasLiked = $likes->contains($user);
                                                                        @endphp
                                                                        @if (!$hasLiked)
                                                                            <form action="/add-like" method="post"
                                                                                id="addlike"
                                                                                data-action="/add-like">
                                                                                @csrf
                                                                                <input type="hidden" name="postId"
                                                                                    value="{{ $post->id }}">
                                                                                <i class="material-symbols-outlined favorite unliked"
                                                                                    onclick="event.preventDefault(); $(this).closest('form').submit();">favorite</i>
                                                                            </form>
                                                                        @else
                                                                            <form action="/remove-like" method="post"
                                                                                id="removelike"
                                                                                data-action="/remove-like">
                                                                                @csrf

                                                                                <input type="hidden" name="postId"
                                                                                    value="{{ $post->id }}">
                                                                                <i class="material-symbols-outlined favorite liked"
                                                                                    onclick="event.preventDefault(); $(this).closest('form').submit();"
                                                                                    style="...">favorite</i>
                                                                            </form>
                                                                        @endif

                                                                    </div>
                                                                </div>

                                                            </div>
                                                        </a>
                                                    </div> --}}
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        @endif

                    </div>


                </div>
            @else
                <div class="row">

                    <div class="col"
                        style="justify-content: center;text-align: center; min-height: 100vh; overflow: auto;">
                        <h1 class="title"
                            style="font-family: serif; font-weight: bold; font-size: 3vw;height: fit-content;padding: 5vw;">
                            Search
                            for genres, book titles, authors or publishers to fill your feed!</h1>
                    </div>

                </div>
            @endif

        </div>

    </div>



    {{-- <div class="row  flex" id="pages">


        <form action="/switch-page" method="get" class="page-form">
            @csrf
            @if (!($page == 0))
                @php
                    if (isset($page)) {
                        $pagenum = $page;
                    }
                @endphp
                <input type="hidden" name="page" value="{{ $pagenum - 1 }}">
                <button type="submit" class="page-button">previous</button>
            @endif
            @if (count($books) == 20)
                <input type="hidden" name="page" value="{{ $pagenum + 1 }}">
                <button type="submit" class="page-button">next</button>
            @endif


        </form>




        @if (count($books) == 20)
            <form action="/switch-page" method="get" class="page-form">
                @csrf

                <input type="hidden" name="page" value="{{ -1 }}">
                <button type="submit" class="page-button">last page</button>
            </form>
        @endif
    </div> --}}





@endsection
