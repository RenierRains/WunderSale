<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'WunderSale') }}</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <!-- Scripts -->
    <script type="text/javascript">
    window.userId = {{ auth()->id() }};
    </script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style> 
        .messages {
        display: flex;
        flex-direction: column-reverse; /* Newest messages at the bottom */
        overflow-y: auto;}
    </style>
</head>
<body class="flex flex-col min-h-screen bg-gray-100">
    <header class="bg-blue-500 shadow-md sticky top-0 z-50">
        <nav class="container mx-auto flex justify-between items-center p-4 text-white">
            <a href="/" class="text-lg font-semibold">{{ config('app.name', 'WunderSale') }}</a>
            <!-- Search bar -->
            <form action="/search" method="GET" class="flex items-center">
                <input type="text" name="query" placeholder="Search..." class="px-4 py-2 w-64 rounded-lg focus:outline-none" />
                <button type="submit" class="ml-4 px-4 py-2 bg-white text-blue-500 rounded-lg hover:bg-gray-100">Search</button>
            </form>
            <!-- Auth Links -->
            <div class="hidden sm:flex sm:items-center">
                @auth
                    <a href="{{ url('/dashboard') }}" class="text-sm text-white font-semibold hover:text-gray-200">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="text-sm text-white font-semibold hover:text-gray-200">Log in</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="ml-4 text-sm text-white font-semibold hover:text-gray-200">Register</a>
                    @endif
                @endauth
            </div>
        </nav>
    </header>

    <main class="flex-grow">
        <div class="container mx-auto px-4 py-8">
            @yield('content')
        </div>
    </main>

    <footer class="bg-blue-500 text-white text-center p-4 shadow-md">
        <div class="container mx-auto">
            &copy; {{ date('Y') }} {{ config('app.name', 'WunderSale') }}. All rights reserved.
        </div>
    </footer>
</body>
</html>
