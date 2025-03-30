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
    </style>
@endpush

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Posts') }}</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        @auth
                            <a href="{{ route('posts.create') }}"  class="btn btn-primary mb-3">Create Post</a>
                        @endauth

                        @foreach($posts as $post)
                            <div class="post-card">
                                <h2>{{ $post->title }}</h2>
                                <p>{{ $post->content }}</p>

                                <div>
                                    <form action="{{ route('posts.toggleLike', $post->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        <button type="submit" class="btn btn-outline-primary">
                                            @if(auth()->user() && auth()->user()->likes()->where('post_id', $post->id)->exists())
                                                Unlike ({{ $post->likes->count() }})
                                            @else
                                                Like ({{ $post->likes->count() }})
                                            @endif
                                        </button>
                                    </form>

                                    <a href="{{ route('posts.show', $post->id) }}" class="btn btn-info">Comment ({{ $post->comments->count() }})</a>
                                    <button class="btn btn-secondary">Send</button>
                                </div>
                                @auth
                                    @if(auth()->user()->id === $post->user_id)
                                    <a href="{{ route('posts.edit', $post->id) }}" class="btn btn-warning">Edit</a>
                                        <form action="{{ route('posts.destroy', $post->id) }}" method="POST" onsubmit="return confirm('Are you sure?');" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">Delete</button>
                                        </form>
                                    @endif
                                @endauth
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
