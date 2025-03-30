@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Edit Post</h2>

    <form action="{{ route('posts.update', $post->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label>Title</label>
            <input type="text" name="title" class="form-control" value="{{ $post->title }}" required>
        </div>

        <div class="form-group">
            <label>Content</label>
            <textarea name="content" class="form-control" required>{{ $post->content }}</textarea>
        </div>

        <button type="submit" class="btn btn-success mt-2">Update</button>
    </form>
</div>
@endsection