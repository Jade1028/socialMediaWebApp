@extends('layouts.app')

@section('content')
<style>
    .hover-shadow:hover {
        box-shadow: 0 0 10px rgba(0,0,0,0.1);
        transition: 0.2s ease;
    }
</style>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

            {{-- Profile Card --}}
            <div class="card mb-4 {{ $bgClass }} {{ $textClass }} {{ $borderClass }}">
                <div class="card-body">
                    <div class="row">
                        {{-- Profile Picture --}}
                        <div class="col-md-4 text-center">
                            <img 
                                src="{{ $user->profile_pic ? asset('storage/' . $user->profile_pic) : 'https://via.placeholder.com/150' }}" 
                                alt="{{ $user->name }}'s Profile Picture" 
                                class="rounded-circle img-thumbnail" 
                                style="width: 150px; height: 150px;"
                            >
                        </div>

                        {{-- User Info --}}
                        <div class="col-md-8">
                            <h2 class="card-title">{{ $user->name }}</h2>
                            <p class="text-muted">Joined: {{ $user->created_at->format('F Y') }}</p>
                            <p class="card-text">{{ $user->bio ?? 'No bio available.' }}</p>

                            {{-- Edit Profile Button (only for owner) --}}
                            @if(auth()->id() === $user->id)
                                <a href="{{ route('profile.edit', $user->id) }}" class="btn btn-primary mt-2">
                                    Edit Profile
                                </a>
                            @endif
                        </div>
                    </div>

                    {{-- Additional Info --}}
                    <div class="row mt-4">
                        <div class="col-md-12">
                            <h4>Additional Information</h4>
                            <p><strong>Email:</strong> {{ $user->email }}</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- User Posts --}}
            <div class="card {{ $bgClass }} {{ $textClass }} {{ $borderClass }}">
                <div class="card-body">
                    <h4 class="card-title">{{ $user->name }}'s Posts</h4>

                    @if($posts->isNotEmpty())
                        @foreach($posts as $post)
                            <a href="{{ route('posts.show', $post->id) }}" class="text-decoration-none text-dark">
                                <div class="card mb-3 hover-shadow {{ $bgClass }} {{ $textClass }} {{ $borderClass }}">
                                    <div class="card-body ">
                                        <h5 class="card-title">{{ $post->title }}</h5>
                                        <p class="card-text">{{ \Illuminate\Support\Str::limit($post->content, 150) }}</p>
                                        <p class="{{ $bgClass }} {{ $textClass }} {{ $borderClass }}">
                                            <small>Posted on {{ $post->created_at->format('M d, Y') }}</small>
                                        </p>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    @else
                        <p class="text-muted">No posts available.</p>
                    @endif
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
