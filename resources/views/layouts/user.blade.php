<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Checkout</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.5.0/font/bootstrap-icons.min.css" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    <style>
        .position-relative {
            position: relative;
        }

        .position-absolute {
            position: absolute;
        }

        .badge {
            display: inline-block;
            padding: .25em .4em;
            font-size: 75%;
            font-weight: 700;
            line-height: 1;
            text-align: center;
            white-space: nowrap;
            vertical-align: baseline;
            border-radius: .375rem;
        }

        .bg-primary {
            background-color: #007bff !important;
        }

        .cart-badge {
            top: 3px; /* Adjusted value to place badge closer */
            right: 14px; /* Adjusted value to place badge closer */
            transform: translate(0, -50%);
        }
    </style>
</head>
<body>
    <div id="app">
        <nav class="navbar bg-white">
            <div class="container">
                <a class="navbar-brand" href="/">
                    <img src="{{ asset('images/logo.png') }}" alt="TB Darma" width="150" height="24">
                </a>
                <div class="d-flex">
                    @guest
                        @if (Route::has('register'))
                            <a class="btn btn-outline-primary me-2" href="{{ route('register') }}">{{ __('Register') }}</a>
                        @endif

                        @if (Route::has('login'))
                            <a class="btn btn-primary" href="{{ route('login') }}">{{ __('Login') }}</a>
                        @endif
                    @else
                        <div class="relative">
                            <a class="nav-link position-relative" href="{{ route('userCheckout') }}">
                                <i class="bi bi-cart fs-5 me-4"></i>
                                @if(isset($cartCount) && $cartCount > 0)
                                    <span class="badge rounded-pill bg-primary position-absolute cart-badge">
                                        {{ $cartCount }}
                                    </span>
                                @endif
                            </a>
                        </div>

                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            <i class="bi bi-person fs-5"></i>
                            {{ Auth::user()->name }}
                        </a>

                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item"  href="{{ route('profil')}}">Edit Profil</a>
                            <a class="dropdown-item" href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    @endguest
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>
</html>
