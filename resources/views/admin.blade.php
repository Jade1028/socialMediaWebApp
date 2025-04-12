@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">Posts</div>
                <div class="card-body">
                    You must be the privileged administrator of this site!
                    <br>Here put your admin dashboard<br>
                    @foreach($posts as $post)
                    <div class="post-card">
                        <h2>{{$post->user->name}}</h2>
                        <hr>
                        <h3>{{ $post->title }}</h3>
                        <p>{{ $post->content }}</p>

                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">Users</div>
                <div class="card-body">
                    This is the second dashboard for additional admin functionalities!
                    <br>Here put your second admin dashboard<br>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
