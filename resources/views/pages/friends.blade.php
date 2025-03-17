@extends('layouts.app')

@section('content')
	<div>
		<h1>Friends</h1>
		<p>This is the friends page</p> <a href="{{route('users.view')}}" >Add friend</a>
		@foreach($friends as $friend)
			<div style="display: flex; align-items: center; margin-bottom: 10px;">
                <p style="margin-right: 10px;">{{ $friend->name }}</p> {{-- Assuming $friend is a User model and has a 'name' attribute --}}
                <a href="{{ route('messages.index', ['id' => $friend->id]) }}" class="btn btn-primary btn-sm">Message</a>
            </div>
		@endforeach
	</div>
@endsection