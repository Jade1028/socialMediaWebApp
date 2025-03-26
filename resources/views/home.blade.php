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
                        @foreach($posts as $post)
                            <div class="post-card">
                                <h2>{{ $post->title }}</h2>
                                <p>{{ $post->content }}</p>
                                <div>
                                    <form action="{{ route('posts.toggleLike', $post->id) }}" method="POST">
                                        @csrf
                                        <button type="submit">
                                            @if(auth()->user() && auth()->user()->likes()->where('post_id', $post->id)->exists())
                                                Unlike ({{ $post->likes->count() }})
                                            @else
                                                Like ({{ $post->likes->count() }})
                                            @endif
                                        </button>
                                    </form>
                                    <a href="{{ route('posts.show', $post->id) }}">
                                        <button>Comment ({{ $post->comments->count() }})</button>
                                    </a>
                                    <button>Send</button>
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