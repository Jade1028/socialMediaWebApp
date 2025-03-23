@extends('layouts.app')

@section('content')

	<div class="card" style="width: 18rem; margin: auto;">
		<div class="card-body text-center">
			<h5 class="card-title">{{ auth()->user()->name }}</h5>
			<p class="card-text">{{ auth()->user()->bio }}</p>
		</div>
	</div>

@endsection