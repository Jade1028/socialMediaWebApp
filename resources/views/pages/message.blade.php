@extends('layouts.app')

@section('title', $friend->name)  {{-- Set the friend name as the title --}}

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    {{-- Chat header --}}
                    <div class="card-header">
                        <strong>{{ $friend->name }}</strong>
                    </div>

                    {{-- Chat messages --}}
                    <div class="card-body" style="height: 400px; overflow-y: auto;">
                        @foreach ($messages as $message)
                            <div class="mb-2 {{ auth()->id() === $message->sender_id ? 'text-right' : 'text-left' }}">
                                <div class="d-inline-block p-2 rounded 
                                    {{ auth()->id() === $message->sender_id ? 'bg-primary text-white' : 'bg-light border' }}">
                                    {{ $message->content }}
                                </div>

                                @if(auth()->id() === $message->sender_id)
                                    {{-- Simple dropdown for message actions --}}
                                    <form id="message-action-form-{{ $message->id }}" method="POST">
                                        @csrf
                                        @method('DELETE')

                                        <select onchange="handleAction(this, '{{ $message->id }}')" class="ml-2">
                                            <option value="" selected disabled>Actions</option>
                                            <option value="edit">Edit</option>
                                            <option value="delete">Delete</option>
                                        </select>
                                    </form>
                                @endif
                            </div>
                        @endforeach

                        {{-- Pagination --}}
                        {{ $messages->links() }}
                    </div>

                    {{-- Message input --}}
                    <div class="card-footer">
                        <form action="{{ route('message.send', ['id' => $friend->id]) }}" method="POST">
                            @csrf
                            <div class="input-group">
                                <textarea name="content" class="form-control" placeholder="Type your message..."></textarea>
                                <button class="btn btn-primary ml-2" type="submit">Send</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function handleAction(select, messageId) {
            let action = select.value;

            if (action === "edit") {
                window.location.href = "{{ route('message.edit', '') }}/" + messageId;
            } else if (action === "delete") {
                if (confirm("Are you sure you want to delete this message?")) {
                    let form = document.getElementById('message-action-form-' + messageId);
                    form.action = "{{ route('message.delete', '') }}/" + messageId;
                    form.submit();
                }
            }

            // Reset dropdown after action
            select.value = "";
        }
    </script>
@endsection
