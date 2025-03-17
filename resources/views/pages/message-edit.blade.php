@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        Edit Message
                    </div>

                    <div class="card-body">
                        @if(isset($message)) {{-- Check if $message is set --}}
                            <form action="{{ route('message.update', ['id' => $message->id]) }}" method="POST">
                                @csrf
                                @method('POST')

                                <div class="form-group">
                                    <label for="content">Message Content</label>
                                    <textarea name="content" id="content" class="form-control @error('content') is-invalid @enderror" rows="5">{{ old('content', $message->content) }}</textarea>
                                    @error('content')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <button type="submit" class="btn btn-primary">Update Message</button>
                                <a href="{{ route('messages.index', ['id' => $friend->id]) }}" class="btn btn-secondary">Cancel</a>
                            </form>
                        @else
                            <p>Message not found.</p> {{-- Or handle the error as needed --}}
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection