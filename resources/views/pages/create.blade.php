@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Create a New Post</h2>

    <form action="{{ route('posts.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label>Title</label>
            <input type="text" name="title" class="form-control" required>
        </div>

        <div class="form-group">
            <label>Content</label>
            <textarea name="content" class="form-control" required></textarea>
        </div>

        <button type="submit" class="btn btn-primary mt-2">Submit</button>
    </form>
</div>
@endsection