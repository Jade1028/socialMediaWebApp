@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            {{--  Profile Picture  --}}
                            <img src="{{ $user->profile_pic ? asset($user->profile_pic) : 'https://via.placeholder.com/150' }}" alt="Profile Picture" class="rounded-circle img-thumbnail" style="width: 150px; height: 150px;">
                        </div>
                        <div class="col-md-8">
                            {{--  User Information  --}}
                            <h2 class="card-title">{{ $user->name }}</h2>
                            <p class="text-muted">Joined: {{ $user->created_at->format('F Y') }}</p> {{--  Added joined date --}}
                            <p class="card-text">{{ $user->bio }}</p>
                            {{--  Display Edit Profile Button only for the logged in user --}}
                            @if(Auth::id() == $user->id)
                                <a href="{{ route('profile.edit', $user->id) }}" class="btn btn-primary mt-2">Edit Profile</a>
                            @endif
                        </div>
                    </div>
                    <div class="row mt-4">
                         <div class="col-md-12">
                            {{--  Any additional profile information can be added here --}}
                            <h3>Additional Information</h3>
                            <p>Email: {{ $user->email }}</p>
                         </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection