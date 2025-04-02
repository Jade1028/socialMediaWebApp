@extends('layouts.app')

@section('content')
	<form action="{{route('users.search')}}" method="get">
		@csrf
		<input type="search" name="name" placeholder="Search for users">
		<button>Search</button>
	</form>
	<div>
		@if(isset($users) && $users->isNotEmpty())
			@foreach($users as $user)
				<div>
					<strong>{{ $user->name }}</strong>
					@if(auth()->user()->isFriend($user->id))
						<a href="{{route('friends.destroy', $user->id)}}" class="text-danger">Unfriend</a>
					@elseif(auth()->user()->hasSentFriendRequestTo($user->id))
						<a disabled>(Request Sent)</a>
					@else
						<a href="{{route('friends.store', $user->id)}}">Add</a>
					@endif
				</div>
			@endforeach
		@endif
	</div>
@endsection