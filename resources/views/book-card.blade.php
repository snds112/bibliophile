@extends('layouts.layout')
@section('styles')
    <link rel="stylesheet" href="{{ asset('/css/book-card.css') }}">
    <link rel="stylesheet" href="{{ asset('/css/layout.css') }}">
@endsection


@section('scripts')
    <script src="{{ asset('/bootstrap/js/jquery-3.7.1.min.js') }}"></script>
@endsection



@section('content')
    {{--  <div class="close-container">

        <button type="button" class="btn-close" id="closeButton" onclick="history.back()"></button>
    </div>
    <div class="container mt-2">

        <div class="row justify-content-center">

            <div class="col-md-6">
                <div class="postcard">
                    @if ($post->type == 'image')
                        <div id="carouselExampleDark" class="carousel carousel-dark slide" data-bs-ride="carousel">

                            <div class="carousel-indicators">
                                @php
                                    $isFirst = true;
                                @endphp

                                @foreach ($post->media as $media)
                                    <button type="button" data-bs-target="#carouselExampleDark"
                                        data-bs-slide-to="{{ $loop->index }}" class="{{ $isFirst ? 'active' : '' }}"
                                        aria-current="true" aria-label="Slide {{ $loop->index + 1 }}"></button>
                                    @php
                                        $isFirst = false;
                                    @endphp
                                @endforeach
                            </div>

                            <div class="carousel-inner">


                                @foreach ($post->media as $media)
                                    <div class="carousel-item {{ $loop->iteration == 1 ? 'active' : '' }}">
                                        <img src="{{ asset($media->addr) }}" class="d-block w-100" alt="PostCard image"
                                            id="{{ $loop->index }}">
                                    </div>
                                @endforeach
                            </div>

                            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleDark"
                                data-bs-slide="prev" id="prevButton">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Previous</span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleDark"
                                data-bs-slide="next" id="nextButton">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Next</span>
                            </button>
                        </div>
                    @elseif ($post->type == 'audio')
                        <div class="media">

                            @if ($post->media[0]->type == 'audio')
                                <img src="{{ asset($post->media[1]->addr) }}" class="media" alt="music cover image">
                                <audio width="100%" controls>
                                    <source src="{{ asset($post->media[0]->addr) }}"
                                        type="audio/{{ pathinfo($post->media[0]->addr, PATHINFO_EXTENSION) }}">
                                    Your browser does not support the audio tag.
                                </audio>
                            @else
                                <img src="{{ asset($post->media[0]->addr) }}" class="media" alt="music cover image">
                                <audio width="100%" controls>
                                    <source src="{{ asset($post->media[1]->addr) }}"
                                        type="audio/{{ pathinfo($post->media[1]->addr, PATHINFO_EXTENSION) }}">
                                    Your browser does not support the audio tag.
                                </audio>
                            @endif

                        </div>
                    @else
                        @foreach ($post->media as $media)
                            @if ($media->type == 'video')
                                <video width="100%" height="100%" controls class="media">
                                    <source src="{{ asset($media->addr) }}"
                                        type="video/{{ pathinfo($media->addr, PATHINFO_EXTENSION) }}">
                                    Your browser does not support the video tag.
                                </video>
                            @endif
                        @endforeach
                    @endif





                    <div class="informations " style="margin: 10px 0px">
                        <div class="row">
                            <div class="col-md-9">
                                <div class="information-userinfo">

                                    <h4> <img src="{{ asset($account->avatar) }}" alt="User's Profile Picture"
                                            style="width: 40px; height: 40px; border-radius: 50%;"> &nbsp;&nbsp; <a
                                            class="mr-2"
                                            href="/profile/{{ $account->username }}">{{ $account->username }}</a>
                                    </h4>

                                    <p class="text-muted">Posted on {{ date('F j, Y', strtotime($post->created_at)) }}
                                    </p>

                                </div>
                            </div>
                            <div class="col-md-3" style="text-align: end;">
                                <div class="information-like_comment_share">
                                    <span>
                                        @php
                                            $post = App\Models\Post::find($post->id);
                                            $likes = $post->likes;
                                            $posters = $post->accounts;
                                            $user = App\Models\Account::find(auth()->user()->id);
                                            $hasLiked = $likes->contains($user);
                                            $hasPosted = $posters->contains($user);

                                        @endphp
                                        @if (!$hasLiked)
                                            <form action="/add-like" method="post" id="addlike">
                                                @csrf
                                                <input type="hidden" name="postId" value= "{{ $post->id }}">
                                                <i class="material-symbols-outlined"
                                                    onclick="document.getElementById('addlike').submit()">favorite</i></button>
                                            </form>
                                        @else
                                            <form action="/remove-like" method="post" id="removelike">
                                                @csrf
                                                <style>
                                                    .favorite {
                                                        font-variation-settings: "FILL" 1, "wght" 400, "GRAD" 0, "opsz" 24;
                                                        color: rgba(238, 15, 15, 0.922);
                                                    }
                                                </style>
                                                <input type="hidden" name="postId" value= "{{ $post->id }}">
                                                <i class="material-symbols-outlined favorite"
                                                    onclick="document.getElementById('removelike').submit()">favorite</i></button>
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
                                        @if ($hasPosted || auth()->user()->type == 'admin')
                                            <form action="/delete-post" method="post" id="deletePost">
                                                @csrf

                                                <input type="hidden" name="postId" value= "{{ $post->id }}">
                                                <i class="material-symbols-outlined "
                                                    onclick="document.getElementById('deletePost').submit()">delete</i></button>
                                            </form>
                                        @endif
                                        @if ($hasPosted && count($posters) > 1)
                                            <form action="/remove-collab" method="post" id="removeCollab">
                                                @csrf

                                                <input type="hidden" name="postId" value= "{{ $post->id }}">
                                                <i class="material-symbols-outlined "
                                                    onclick="document.getElementById('removeCollab').submit()">person_remove</i></button>
                                            </form>
                                        @endif

                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <p>{!! $post->caption !!}
                            </p>
                            @if (count($posters) > 1)
                                <hr>
                                <span>In collaboration with :</span>
                                <br>
                                @foreach ($posters as $collaber)
                                    @if ($collaber->username != $account->username)
                                        <span>- <a href="/profile/{{ $collaber->username }}"
                                                style="text-decoration: underline">{{ $collaber->username }}
                                            </a></span>
                                    @endif
                                @endforeach
                            @endif
                            <div class="mt-3">

                                @if ($post->likes()->count() == 1)
                                    <strong>
                                        {{ $post->likes()->count() }} like
                                    </strong>
                                @else
                                    <strong>
                                        {{ $post->likes()->count() }} likes
                                    </strong>
                                @endif
                                |
                                @if ($post->comments()->count() == 1)
                                    <strong>
                                        {{ $post->comments()->count() }} comment
                                    </strong>
                                @else
                                    <strong>
                                        {{ $post->comments()->count() }} comments
                                    </strong>
                                @endif


                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 ">



                <div class="comment-bottom p-2 px-4" style="border-radius: .25rem; background-color: #fff;">
                    <div class="d-flex flex-row add-comment-section mt-4 mb-4"
                        style="position: sticky; top: 0; background-color: #fff; margin: 5px;"><img
                            class="img-fluid img-responsive rounded-circle mr-2"
                            src="{{ asset(auth()->user()->avatar) }}"
                            style="width: 40px; height: 40px; border-radius: 50%; margin: 0px 10px">


                        <form action="/add-comment" method="post" class="full-width">
                            @csrf
                            <input type="text" class="form-control flex-grow-1 mr-3" placeholder="Add comment"
                                name="commentcontent">
                            <input type="hidden" name="postId" value="{{ $post->id }}">
                            <button type="submit" class="btn btn-outline-commment"
                                style="background-color: #d1c7bd">Comment</button>
                        </form>



                    </div>

                    <div class="comment-section py-0">
                        @foreach ($post->comments as $comment)
                            <div class="commented-section  mt-3" style="border-radius: 10px; display: flex;">
                                <div class="comment-content" style="width: 100%">
                                    <div class="d-flex flex-row align-items-center commented-user">
                                        @php
                                            $commenter = $comment->account()->get();
                                            $user = App\Models\Account::find(auth()->user()->id);

                                        @endphp
                                        <img src="{{ asset($commenter[0]->avatar) }}"
                                            style="width: 20px; height: 20px; border-radius: 50%;"
                                            alt="Use's profile picture">
                                        <h6 class="mr-2">{{ $commenter[0]->username }}</h6>

                                    </div>
                                    <div class="comment-text-sm"><span>
                                            <h5>{{ $comment->content }}</h5>
                                        </span></div>
                                </div>
                                @if (auth()->user()->type == 'admin' || $commenter->contains($user))
                                    <div class="form-group" style="font-size: 1rem">
                                        <form action="/delete-comment" method="POST">
                                            @csrf

                                            <button type="submit" class="btn btn-danger"
                                                style="padding: 0.25rem; margin: 0.25rem;" name="comment-id"
                                                value="{{ $comment->id }}">
                                                <span class="material-symbols-outlined">
                                                    delete
                                                </span>
                                            </button>
                                        </form>
                                    </div>
                                @endif

                            </div>
                        @endforeach


                    </div>
                </div>
            </div>
        </div>
    </div> --}}
@endsection
