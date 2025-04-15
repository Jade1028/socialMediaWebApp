@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Edit Post</h2>

    <form action="{{ route('posts.update', $post->id) }}" method="POST" enctype="multipart/form-data">
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

        <div class="form-group">
            <label>Current Image</label><br>
            @if($post->image_url)
                <img src="{{ asset('storage/' . $post->image_url) }}" alt="Post Image" style="max-width: 200px; height: auto;">
            @else
                <p>No image uploaded.</p>
            @endif
        </div>

        <div class="form-group">
            <label for="image">Replace Image (Optional)</label>
            <input type="file" class="form-control-file" name="image" accept="image/*">
        </div>

        <button type="submit" class="btn btn-success mt-2">Update</button>
    </form>
</div>
@endsection