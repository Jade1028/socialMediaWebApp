<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Y</title>
</head>
<body>
    <div class="container">
        <h1>Welcome to Y!</h1>

        <p>We are glad to have you here. Explore our features and enjoy your stay.</p>

        @if (Route::has('login'))
            <div class="hidden fixed top-0 right-0 px-6 py-4 sm:block">
                @auth
                    <a href="{{ url('/home') }}" class="text-sm text-gray-700 dark:text-gray-500 underline">Home</a>
                @else
                    <a href="{{ route('login') }}" class="text-sm text-gray-700 dark:text-gray-500 underline">Log in</a>

                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="ml-4 text-sm text-gray-700 dark:text-gray-500 underline">Register</a>
                    @endif
                @endauth
            </div>
        @endif

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
</body>
</html>