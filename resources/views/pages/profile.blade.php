@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
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
                            {{-- Add other optional info here --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
