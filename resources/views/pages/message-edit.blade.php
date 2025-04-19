@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header text-center {{ $bgClass}} {{ $textClass}} {{ $borderClass}}">
                        <h4>Edit Message</h4>
                    </div>

                    <div class="card-body {{ $bgClass}} {{ $textClass}} {{ $borderClass}}">
                        @if(isset($message))
                            <form action="{{ route('message.update', ['id' => $message->id]) }}" method="POST">
                                @csrf
                                @method('POST')

                                <div class="form-group">
                                    <label for="content">Message Content</label>
                                    <textarea name="content" id="content" class="form-control @error('content') is-invalid @enderror" rows="5" required>{{ old('content', $message->content) }}</textarea>
                                    @error('content')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <button type="submit" class="btn btn-success btn-block">Update Message</button>
                                <a href="{{ route('messages.index', ['id' => $friend->id]) }}" class="btn btn-secondary btn-block mt-2">Cancel</a>
                            </form>
                        @else
                            <p>Message not found.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
