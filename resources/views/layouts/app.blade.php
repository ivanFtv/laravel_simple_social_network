<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;0,800;1,200;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/07e51218b4.js" crossorigin="anonymous"></script>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container width-header px-5">
                <a class="navbar-brand" href="{{ url('/home') }}">
                    <img src="/images/logo.png" class="logo" alt="Digibook team Beta"> 
                    {{-- {{ config('app.name', 'Laravel') }} --}}
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent"> 
                    @guest
                    
                    @else
                    <!-- Center icons Of Navbar -->
                    <ul class="navbar-nav mx-auto icons-menu">
                        <a href="http://localhost:8000/home"><li class="mx-4"><i class="fa-solid fa-house fa-xl"></i></li></a>
                        <li class="mx-4"><i class="fa-solid fa-video fa-xl"></i></li>
                        <li class="mx-4"><i class="fa-solid fa-image fa-xl"></i></li>
                        <a href=" {{ route('profile') }} "><li class="mx-4"><i class="fa-solid fa-user fa-xl"></i></li></a>
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ps-3 user-menu">
                        <!-- Authentication Links -->
                        <li class="nav-item dropdown">
                            <img src="{{ asset('avatars/'. Auth::user()->avatar ) }}" class="border rounded-circle" style=" object-fit:cover; width:40px; height: 40px; display:inline-block;">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" style="display:inline-block;" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->username }}
                            </a>

                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item text-primary" href=" {{ route('profile') }} ">
                                    {{ __('My Profile') }}
                                </a>
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="pt-4">
            @yield('content')
        </main>
    </div>

</body>
</html>
