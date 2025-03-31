@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Edit Comment</h2>
    <form action="{{ route('comments.update', $comment->id) }}" method="POST">
        @csrf
        @method('PUT')
        <textarea name="content" class="form-control mb-2" required>{{ $comment->content }}</textarea>
        <button type="submit" class="btn btn-primary">Update Comment</button>
    </form>
</div>
@endsection