<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/4.1.2/socket.io.js"></script>
    <input type="hidden" id="authUserId" value="{{ !is_null(\Illuminate\Support\Facades\Auth::user()) ? \Illuminate\Support\Facades\Auth::user()->id : 0 }}">


    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item"><a href="{{ route('product.index') }}" class="btn btn-outline-dark">Products</a></li>
                        <li class="nav-item ml-2"><a href="{{ route('cart.index') }}" class="btn btn-outline-dark">Cart</a></li>
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                    @if(Auth::user()->is_admin)
                                    <span class="badge badge-success notification_span"></span>
                                    @endif
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">

                                    @if(Auth::user() && \Illuminate\Support\Facades\Auth::user()->is_admin)
                                        <a class="dropdown-item" href="{{ route('admin.dashboard') }}">Dashboard</a>
                                    @endif
                                    @if(Auth::user() && !\Illuminate\Support\Facades\Auth::user()->is_admin && Auth::guard()->name != 'employer')
                                        <a class="dropdown-item" href="{{ route('user.dashboard') }}">My profile</a>
                                    @endif
                                    @if(Auth::guard()->name == 'employer')
                                        <a class="dropdown-item" href="{{ route('employer.dashboard') }}">My Profile</a>
                                    @endif
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
{{--        @include('layouts.sidebar')--}}
        <main class="py-4">
            @yield('content')
        </main>
    </div>
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/4.2.0/socket.io.js"></script>

    <script>
        let token = $('input[name="_token"]').val();

        const socketUrl = 'http://localhost:8000'; // Replace with your Socket.IO server URL

        const socket = io(socketUrl, {
            autoConnect: true,
            transports: ['websocket', 'polling'],
            forceNew: true,
            reconnectionDelay: 50,
            path: '/websocket',
            auth: (cb) => {
                cb({
                    token: `${token}`,
                });
            },
        });

        socket.connect();

        socket.on('connect', () => {
            socket.emit('online');
            // alert(1)
        });
    </script>

    <script>
        $(document).ready(function (){

            let token = $('input[name="_token"]').val();

            $.ajax(
                {
                    url: "{{ route('admin.notifications') }}",
                    method: 'POST',
                    dataType: 'json',
                    headers: {
                        'X-CSRF-Token': token
                    },
                    success: function(count) {
                        $(".notification_span").append(count)


                        // var socket = $.simpleWebSocket({
                        //     url: 'ws://127.0.0.1:3000/',
                        //     protocols: 'your_protocol', // optional
                        //     timeout: 20000, // optional, default timeout between connection attempts
                        //     attempts: 60, // optional, default attempts until closing connection
                        //     dataType: 'json' // optional (xml, json, text), default json
                        // });
                        //
                        // socket.connect();
                        //
                        // socket.isConnected(); // or: socket.isConnected(function(connected) {});
                    },
                    error: function(error) {
                        console.log(error);
                    }
                })
        })
    </script>
</body>
</html>
