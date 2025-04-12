@extends('layouts.app')
@section('content')
    <div class="container">
        <h1>Welcome to Y!</h1>

        <p>We are glad to have you here. Explore our features and enjoy your stay.</p>

        <div class="features">
            <h2>Our Features</h2>
            <ul>
                <li>Feature 1: Description of feature 1.</li>
                <li>Feature 2: Description of feature 2.</li>
                <li>Feature 3: Description of feature 3.</li>
            </ul>
        </div>

        <div class="contact">
            <h2>Contact Us</h2>
            <p>If you have any questions, feel free to <a href="{{ url('/contact') }}">contact us</a>.</p>
        </div>
    </div>
@endsection