@extends('layouts.app')

@section('content')
	<div>
		<h1>Friends</h1>
		<p>This is the friends page</p> <a href="{{route('users.view')}}" >Add friend</a>
		@foreach($friends as $friend)
			<p>{{ $friend }}</p>
		@endforeach
	</div>
@endsection