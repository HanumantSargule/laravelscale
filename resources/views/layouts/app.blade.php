<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Service Marketplace</title>
    
    <!-- <link rel="stylesheet" href="{{ asset('css/style.css') }}"> -->
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
          rel="stylesheet">
</head>
<body>

<nav>
    <a href="{{ route('listings.index') }}">Home</a>

    @auth
        <a href="{{ route('dashboard') }}">Dashboard</a>
        <form method="POST" action="{{ route('logout') }}" style="display:inline;">
            @csrf
            <button type="submit">Logout</button>
        </form>
    @else
        @if(Route::has('login'))
            <a href="{{ route('login') }}">Login</a>
        @endif

        @if(Route::has('register'))
            <a href="{{ route('register') }}">Register</a>
        @endif
    @endauth
</nav>

<hr>

@if(session('success'))
    <p style="color:green;">
        {{ session('success') }}
    </p>
@endif

@yield('content')

</body>
</html>
