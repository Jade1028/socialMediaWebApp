@extends('layouts.app')

@push('styles')
    <style>
		.w-5{
			display: none;
		}
		.post-card{
			border: 1px solid #ccc;
			padding: 10px;
			margin: 10px 0;
		}
	</style>
@endpush

@section('content')
<div class="container">
	
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Posts') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    @foreach($posts as $post)
                        <div class="post-card">
                            <h2>{{ $post->title }}</h2>
                            <p>{{ $post->content }}</p>
                            <div>
                                <button>Like</button>
                                <button>Comment</button>
                                <button>Send</button>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

<div class="pagination-wrapper">
    {{ $posts->links() }}
</div>
@endsection
