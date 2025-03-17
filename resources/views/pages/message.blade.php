@extends('layouts.app') {{-- Assuming you have a layout file --}}

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        {{ $friend->name }} {{-- Display the receiver's name --}}
                    </div>

                    <div class="card-body" style="height: 400px; overflow-y: auto;">
                        {{-- Message display area --}}
                        @foreach ($messages as $message)
                            <div class="mb-2 {{ auth()->id() === $message->sender_id ? 'text-right' : 'text-left' }}">
                                <div class="d-inline-block p-2 rounded {{ auth()->id() === $message->sender_id ? 'bg-primary text-white' : 'bg-light border' }}">
                                    {{ $message->content }}
                                </div>
                                @if(auth()->id() === $message->sender_id)
                                    <div class="dropdown d-inline-block">
                                        <button class="btn btn-sm btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            ...
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                            <a class="dropdown-item" href="{{ route('message.edit', ['id' => $message->id]) }}">Edit</a>
                                            <a class="dropdown-item" href="{{ route('message.delete', ['id' => $message->id]) }}" onclick="event.preventDefault(); document.getElementById('delete-form-{{ $message->id }}').submit();">Delete</a>

                                            <form id="delete-form-{{ $message->id }}" action="{{ route('message.delete', ['id' => $message->id]) }}" method="POST" style="display: none;">
                                                @csrf
                                                @method('DELETE')
                                            </form>

                                        </div>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                        {{ $messages->links() }} {{-- Pagination links --}}
                    </div>

                    <div class="card-footer">
                        {{-- Message input form --}}
                        <form action="{{ route('message.send', ['id' => $friend->id]) }}" method="POST">
                            @csrf
                            <div class="input-group">
                                <textarea name="content" class="form-control" placeholder="Type your message..."></textarea>
                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="submit">Send</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection