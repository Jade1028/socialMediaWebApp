@extends('layouts.app')

@push('styles')
    <style>
        .w-5 {
            display: none;
        }

        .post-card {
            border: 1px solid #ccc;
            padding: 10px;
            margin: 10px 0;
        }

        .post-image {
            margin: 15px 0;
            overflow: hidden;
            border-radius: 8px;
        }

        .post-image img {
            max-width: 100%;
            height: auto;
            display: block;
            transition: transform 0.3s ease;
        }

        .post-image img:hover {
            transform: scale(1.02);
        }
    </style>
@endpush

@section('content')
    <div class="container">
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card {{ $bgClass}} {{ $textClass}} {{ $borderClass}}">
                    <div class="card-header">{{ __('Posts') }}</div>

                    <div class="card-body {{ $bgClass}} {{ $textClass}}">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        @auth
                            <a href="{{ route('posts.create') }}" class="btn btn-primary mb-3">Create Post</a>
                        @endauth

                        @foreach($posts as $post)
                            <div class="post-card {{ $bgClass}} {{ $textClass}}">
                                <h2>{{$post->user->name}}</h2>
                                <hr>
                                <h3>{{ $post->title }}</h3>
                                <p>{{ $post->content }}</p>

                                @if($post->image_url)
                                    <div class="post-image">
                                    <img src="/storage/{{ $post->image_url }}" alt="Post image" class="img-fluid mb-3">
                                    </div>
                                @endif

                                <div>
                                    <form action="{{ route('posts.toggleLike', $post->id) }}" method="POST"
                                        style="display:inline;">
                                        @csrf
                                        <button type="submit" class="btn btn-outline-primary">
                                            @if(auth()->user() && auth()->user()->likes()->where('post_id', $post->id)->exists())
                                                Unlike ({{ $post->likes->count() }})
                                            @else
                                                Like ({{ $post->likes->count() }})
                                            @endif
                                        </button>
                                    </form>

                                    <a href="{{ route('posts.show', $post->id) }}" class="btn btn-info">Comment
                                        ({{ $post->comments->count() }})</a>
                                        <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#shareModal{{$post->id}}">Share</button>
                                </div>
                                @auth
                                    @can('update', $post)
                                        <a href="{{ route('posts.edit', $post->id) }}" class="btn btn-warning">Edit</a>
                                        <form action="{{ route('posts.destroy', $post->id) }}" method="POST"
                                            onsubmit="return confirm('Are you sure?');" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">Delete</button>
                                        </form>
                                    @endcan
                                @endauth
                            </div>
                        @endforeach
                        @foreach($posts as $post)
                            <div class="modal fade" id="shareModal{{$post->id}}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content {{ $bgClass}} {{ $textClass}}">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Share Post with Friend</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <form action="{{ route('posts.share-message', $post->id) }}" method="POST">
                                            @csrf
                                            <div class="modal-body">
                                                <div class="form-group">
                                                    <label for="friend_id">Select Friend</label>
                                                    <select name="friend_id" class="form-control" required>
                                                        <option value="">Choose a friend</option>
                                                        @php
                                                            $userId = auth()->id();
                                                            // Get friendships where user is either sender or receiver
                                                            $friendships = \App\Models\Friend::where(function($query) use ($userId) {
                                                                $query->where('user_id1', $userId)
                                                                      ->orWhere('user_id2', $userId);
                                                                })->where('status', 'accepted')->get();
                                                            @endphp
    
                                                        @foreach($friendships as $friendship)
                                                            @php
                                                                $friend = $friendship->user_id1 == $userId 
                                                                    ? \App\Models\User::find($friendship->user_id2)
                                                                    : \App\Models\User::find($friendship->user_id1);
                                                            @endphp
                                                            <option value="{{ $friend->id }}">{{ $friend->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary">Share Post</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="pagination-wrapper">
        {{ $posts->links() }}
    </div>
@endsection