<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    @stack('styles')
</head>
<body class="{{ $bgClass }} {{ $textClass }}">
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light shadow-sm border {{ $borderClass }}">
            <div class="container">
                @if(Auth::guard('admin')->check())
                <a class="navbar-brand {{ $textClass }}" href="{{ url('/admin') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                @else
                <a class="navbar-brand {{ $textClass }}" href="{{ url('/home') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                @endif
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto ">
                        @if(!Auth::guard('admin')->check())
                        <li class="nav-item">
                            <a class="nav-link {{ $textClass }}" href="{{route('friends')}}">{{ __('Friends') }}</a>
                        </li>
                        <li class="nav-item {{ $textClass }}">
                            <a class="nav-link {{ $textClass }}" href="">{{ __('Messages') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ $textClass }}" href="{{ route('about') }}">{{ __('About') }}</a>
                        </li>
                        @endif
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        @guest
                        @if (Route::has('login'))
                        <li class="nav-item">
                            <a class="nav-link {{$textClass}}" href="{{ route('login') }}">{{ __('Login') }}</a>
                        </li>
                        @endif

                        @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link {{$textClass}}" href="{{ route('register') }}">{{ __('Register') }}</a>
                        </li>
                        @endif
                        @else
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle {{$textClass}}" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>

                                @if(Auth::guard('admin')->check())
                                <span class="{{$textClass}}">Hi, Admin {{ Auth::guard('admin')->user()->name}}</span> 
                                @else
                                <span class="{{$textClass}}">{{ Auth::user()->name }}</span>
                                @endif
                            </a>

                            <div class="dropdown-menu dropdown-menu-end {{$bgClass}}" aria-labelledby="navbarDropdown">
                                @if(!Auth::guard('admin')->check())
                                <a class="dropdown-item {{$textClass}}" href="{{ route('profile.show', ['id'=>Auth::user()->id]) }}">
                                    {{ __('Profile') }}
                                </a>
                                @endif
                                <a class="dropdown-item {{$textClass}}" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                                <form action="{{route('theme.toggle')}}" method='post'>
                                    @csrf
                                    <button type="submit">
                                        @if (request()->cookie('theme') === 'dark')
                                        Switch to Light Mode
                                        @else
                                        Switch to Dark Mode
                                        @endif
                                    </button>
                                </form>
                            </div>

                        </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>

        <footer class="text-center text-lg-start">
            <div class="container p-4">
                <div class="row">
                    <div class="col-lg-6 col-md-12 mb-4 mb-md-0">
                        <h5 class="text-uppercase">Follow Us</h5>
                        <ul class="list-unstyled mb-0">
                            <li>
                                <a href="https://www.facebook.com/Y"  target="_blank">Facebook</a>
                            </li>
                            <li>
                                <a href="https://www.twitter.com/Y"  target="_blank">Twitter</a>
                            </li>
                            <li>
                                <a href="https://www.instagram.com/Y" target="_blank">Instagram</a>
                            </li>
                        </ul>
                    </div>
                    <div class="col-lg-6 col-md-12 mb-4 mb-md-0">
                        <h5 class="text-uppercase">Stay Connected</h5>
                        <p>Follow us on social media for the latest updates and news.</p>
                        <p>Stay connected with us for exclusive content and promotions.</p>
                        <p>Join our community and be a part of the conversation.</p>
                    </div>
                </div>
            </div>
            <div class="text-center p-3">
                &copy; {{ date('Y') }} Y. All rights reserved.
            </div>
        </footer>
    </div>
</body>
</html>
