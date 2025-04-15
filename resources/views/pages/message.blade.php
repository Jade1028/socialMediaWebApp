@extends('layouts.app')
@push('styles')
<style>
    .bg-primary.text-white a {
        color: white;
        text-decoration: underline;
    }
    
    .bg-primary.text-white a:hover {
        color: #f0f0f0;
        text-decoration: none;
    }
</style>
@endpush
@section('title', $friend->name)

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header text-center">
                        <strong>{{ $friend->name }}</strong> <small class="text-muted">Chat</small>
                    </div>

                    <div class="card-body" style="height: 400px; overflow-y: auto;">
                        @foreach ($messages as $message)
                            <div class="mb-2 {{ auth()->id() === $message->sender_id ? 'text-right' : 'text-left' }}">
                                <div class="d-inline-block p-2 rounded 
                                    {{ auth()->id() === $message->sender_id ? 'bg-primary text-white' : 'bg-light border' }}">
                                    {!! nl2br($message->content) !!}
                                </div>

                                @if(auth()->id() === $message->sender_id)
                                    <form id="message-action-form-{{ $message->id }}" method="POST" class="d-inline-block ml-2">
                                        @csrf
                                        @method('DELETE')

                                        <select onchange="handleAction(this, '{{ $message->id }}')" class="form-control-sm">
                                            <option value="" selected disabled>Actions</option>
                                            <option value="edit">Edit</option>
                                            <option value="delete">Delete</option>
                                        </select>
                                    </form>
                                @endif
                            </div>
                        @endforeach

                        {{-- Pagination --}}
                        <div class="text-center">
                            {{ $messages->links() }}
                        </div>
                    </div>

                    <div class="card-footer">
                        <form action="{{ route('message.send', ['id' => $friend->id]) }}" method="POST">
                            @csrf
                            <div class="input-group">
                                <textarea name="content" class="form-control" placeholder="Type your message..." rows="3" required></textarea>
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

            select.value = "";
        }
    </script>
@endsection
