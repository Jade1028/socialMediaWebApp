@extends('layouts.app')
@section('content')

@push('styles')
    <style>
        .w-5 {
            display: none;
        }
        .pagination {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }
        .row.justify-content-center {
            display: flex;
            flex-wrap: wrap;
        }
        .col-md-6 {
            flex: 0 0 48%;
            max-width: 48%;
            margin: 1%;
        }
        .col-md-4 {
            flex: 0 0 30%;
            max-width: 30%;
            margin: 1%;
        }
        .dashboard-container {
            display: flex;
            justify-content: space-between;
            gap: 2%;
        }
    </style>
@endpush
<div class="container">
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <div class="dashboard-container">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">Posts</div>
                <div class="card-body">
                    @foreach($posts as $post)
                    <div class="post-card">
                        <h2>{{$post->user->name}}</h2>
                        <hr>
                        <h3>{{ $post->title }}</h3>
                        <p>{{ $post->content }}</p>

                    </div>
                    <form action="{{ route('admin.deletePost', $post->id) }}" method="POST" onsubmit="return confirm('Are you sure?');" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                    <hr><hr>
                    @endforeach
                    <div class="pagination">
                        {{$posts->links()}}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">Users</div>
                <div class="card-body">
                    @foreach($users as $user)
                    <div class="user-card">
                        <h2>{{$user->name}}</h2>
                        <hr>
                        <p>Email: {{ $user->email }}</p>
                        <p>Created at: {{ $user->created_at }}</p>
                        @if($user->is_banned)
                            <p style="color: red; font-weight: bold;">Status: Banned</p>
                        @else
                            <form action="{{route('admin.banUser', $user->id)}}" method='POST'>
                                @csrf
                                <button type="submit" class="btn btn-danger">Ban user</button>
                            </form>
                        @endif
                        <hr>
                        <hr>
                    </div>
                    @endforeach
                    <div class="pagination">
                        {{$users->links()}}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">Banned Users</div>
                <div class="card-body">
                    @foreach($bannedUsers as $bannedUser)
                    <div class="banned-user-card">
                        <h2>{{$bannedUser->name}}</h2>
                        <hr>
                        <p>Email: {{ $bannedUser->email }}</p>
                        <p>Banned at: {{ $bannedUser->updated_at }}</p>
                        <p style="font-style: italic; color: grey; font-weight: bold;">User is permanently banned</p>
                        <hr>
                        <hr>
                    </div>
                    @endforeach
                    <div class="pagination">
                        {{$bannedUsers->links()}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
