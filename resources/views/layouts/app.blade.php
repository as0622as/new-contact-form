<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>FashionablyLate</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    @yield('css')
</head>
<body>
<header class="header">
    <div class="header-inner">
        <h1 class="site-title">FashionablyLate</h1>

        <nav class="header-nav">
            @if (request()->routeIs('login'))
                <a href="{{ route('register') }}" class="nav-btn">Register</a>
            @elseif (request()->routeIs('register'))
                <a href="{{ route('login') }}" class="nav-btn">Login</a>
            @elseif (auth()->check())
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button class="nav-btn">Logout</button>
                </form>
            @endif
        </nav>
    </div>
</header>

@yield('page-title')

<main class="main">
    @yield('content')
</main>

</body>
</html>