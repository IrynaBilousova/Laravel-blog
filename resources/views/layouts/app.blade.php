<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <style>
        [v-cloak] { display: none; }
    </style>
    <script type="text/javascript">
        window.Globals =  {!!
         json_encode([
            'signedIn' => Auth::check(),
            'user' => Auth::user()
        ])
        !!};
    </script>
</head>
<body style="padding-bottom:100px;">
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light navbar-laravel">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">
                        <li class="dropdown">
                            <button class="btn btn-light dropdown-toggle" type="button" data-toggle="dropdown">Browse<span class="caret"></span></button>
                            <ul class="dropdown-menu">
                                <li>
                                    <a class="navbar-brand" href="{{ url('/posts') }}">
                                        All Posts
                                    </a>
                                </li>
                                <li>
                                    <a class="navbar-brand" href="{{ url('/posts?popular=1') }}">
                                        Popular
                                    </a>
                                </li>
                                @if(auth()->check())
                                    <li>
                                        <a class="navbar-brand" href="{{ url('/posts?by=' . auth()->user()->name) }}">
                                            My Posts
                                        </a>
                                    </li>
                                @endif
                            </ul>
                        </li>


                        <li>
                            <a class="navbar-brand" href="{{ url('/posts/create') }}">
                               New Post
                            </a>
                        </li>
                        <li>
                            <div class="dropdown">
                                <button class="btn btn-light dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Categories
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    @foreach($categories as $category)
                                    <a class="dropdown-item" href="{{route('posts_with_category', $category->slug)}}">{{$category->name}}</a>
                                    @endforeach
                                </div>
                            </div>

                        </li>
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li><a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a></li>
                            <li><a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a></li>
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ url('posts?by='. Auth::user()->name) }}">My Blog</a>
                                    <a class="dropdown-item" href="{{ route('profile', Auth::user()->name) }}">Profile</a>
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
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

            <flash message="{{ session('flash') }}"></flash>
        </main>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>

</body>
</html>
