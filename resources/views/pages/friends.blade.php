@extends('layouts.app')

@section('content')
	<div>
		<section class="">
			<h1>Friends</h1>
			<p>Looking for a friend ? <a href="{{route('users.view')}}" >Add friend</a></p> 
		</section>
		<section class="d-flex justify-content-evenly">
			<section class="border border-primary">
				<h2>Friend requests</h2>
				@if($pendingFriends->isEmpty())
					<p>You have no friends</p>
				@endif
				@foreach($pendingFriends as $friend)
					<div style="display: flex; align-items: center; margin-bottom: 10px;">
						<p style="margin-right: 10px;">{{ $friend->name }}</p> {{-- Assuming $friend is a User model and has a 'name' attribute --}}
						<a href="{{ route('messages.index', ['id' => $friend->id]) }}" class="btn btn-primary btn-sm">Message</a>
						<a href="{{route('friends.accept', $friend->id)}}" class="btn btn-success btn-sm">Accept</a>
						<a href="{{route('friends.reject', $friend->id)}}" class="btn btn-danger btn-sm">Reject</a>
					</div>
				@endforeach
			</section>
			<section class="border border-primary">
				<h2>Accepted friends</h2>
				@if($acceptedFriends->isEmpty())
					<p>You have no friends</p>
				@endif
				@foreach($acceptedFriends as $friend)
					<div style="display: flex; align-items: center; margin-bottom: 10px;">
						<p style="margin-right: 10px;">{{ $friend->name }}</p> {{-- Assuming $friend is a User model and has a 'name' attribute --}}
						<a href="{{ route('messages.index', ['id' => $friend->id]) }}" class="btn btn-primary btn-sm">Message</a>
						<a href="{{route('friends.destroy', $friend->id)}}" class="text-danger">Unfriend</a>
					</div>
				@endforeach
			</section>
		
		</section>
		
		
	</div>
@endsection