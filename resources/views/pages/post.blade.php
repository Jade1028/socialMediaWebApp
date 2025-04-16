@extends('layouts.app')
@section('content')
@push('styles')
<style>
    .post-image {
        max-width: 500px;  /* Limit maximum width */
        margin: 15px 0;
        overflow: hidden;
        border-radius: 8px;
    }

    .post-image img {
        width: 100%;
        height: auto;
        object-fit: cover;
        display: block;
        transition: transform 0.3s ease;
    }

    .post-image img:hover {
        transform: scale(1.02);
    }
</style>
@endpush
    <div class="post-card">
        <a href="{{ route('home') }}">
            << Back</a>
                <h2>{{ $post->title }}</h2>
                <p>{{ $post->content }}</p>
                @if($post->image_url)
                    <div class="post-image">
                    <img src="/storage/{{ $post->image_url }}" alt="Post image" class="img-fluid mb-3">
                    </div>
                @endif

                <h3>Comments ({{ $post->comments->count() }})</h3>

                @foreach($post->comments as $comment)
                    <p><strong>{{ $comment->user->name }}</strong>: {{ $comment->content }}</p>

                    @can('update', $comment)
                        <a href="{{ route('comments.edit', $comment->id) }}" class="btn btn-sm btn-warning">Edit</a>
                    @endcan

                    @can('delete', $comment)
                        <form action="{{ route('comments.destroy', $comment->id) }}" method="POST"
                            onsubmit="return confirm('Are you sure you want to delete this comment?');" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                        </form>
                    @endcan
                    <br><br>
                @endforeach

                <form action="{{ route('comments.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="post_id" value="{{ $post->id }}">
                    <textarea name="content" required placeholder="Write a comment..." rows="4" cols="50"></textarea>
                    <br>
                    <button type="submit">Comment</button>
                </form>
    </div>
@endsection