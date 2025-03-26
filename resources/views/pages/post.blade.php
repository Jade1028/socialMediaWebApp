@extends('layouts.app')
@section('content')
    <div class="post-card">
    <a href="{{ route('home') }}"><< Back</a>
        <h2>{{ $post->title }}</h2>
        <p>{{ $post->content }}</p>

        <h3>Comments ({{ $post->comments->count() }})</h3>

        @foreach($post->comments as $comment)
            <p><strong>{{ $comment->user->name }}</strong>: {{ $comment->content }}</p>
        @endforeach

        @auth
            <form action="{{ route('posts.comment', $post->id) }}" method="POST">
                @csrf
                <textarea name="content" required placeholder="Write a comment..." rows="4" cols="50"></textarea>
                <br>
                <button type="submit">Comment</button>
            </form>
        @endauth
    </div>
@endsection