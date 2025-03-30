@extends('layouts.app')

@section('content')
<div class="container">
    <h2>All Posts</h2>
    <a href="{{ route('posts.create') }}" class="btn btn-primary mb-3">Create New Post</a>

    @foreach($posts as $post)
        <div class="card mb-3">
            <div class="card-body">
                <h5 class="card-title">{{ $post->title }}</h5>
                <p class="card-text">{{ Str::limit($post->content, 100) }}</p>
                <a href="{{ route('posts.show', $post->id) }}" class="btn btn-info">View</a>

                @if(Auth::check() && Auth::id() === $post->user_id)
                    <a href="{{ route('posts.edit', $post->id) }}" class="btn btn-warning">Edit</a>
                    <form action="{{ route('posts.destroy', $post->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                    </form>
                @endif
            </div>
        </div>
    @endforeach

    {{ $posts->links() }}
</div>
@endsection