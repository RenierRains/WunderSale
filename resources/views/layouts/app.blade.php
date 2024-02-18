<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'WunderSale') }}</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script type="text/javascript">
    window.userId = {{ auth()->id() }};
    </script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="//unpkg.com/alpinejs" defer></script>
    <style> 
        .messages {
        display: flex;
        flex-direction: column-reverse; /* Newest messages at the bottom test */
        overflow-y: auto;}

        /* For Webkit browsers like Chrome, Safari */
        input[type="number"]::-webkit-inner-spin-button, 
        input[type="number"]::-webkit-outer-spin-button { 
            -webkit-appearance: none; 
            margin: 0; 
        }

        /* For Mozilla Firefox */
        input[type="number"] {
            -moz-appearance: textfield;
        }
    </style>
</head>
<body class="flex flex-col min-h-screen bg-gray-100">
    <header class="bg-blue-500 shadow-md sticky top-0 z-50">
        <nav class="container mx-auto flex justify-between items-center p-4 text-white">
            <a href="/" class="text-lg font-semibold">{{ config('app.name', 'WunderSale') }}</a>
            <!-- Search -->
            <form action="{{ route('search') }}" method="GET" class="flex items-center flex-grow mx-4">
            <input type="text" name="query" placeholder="Search in WunderSale" class="text-black px-4 py-2 w-full rounded-lg focus:outline-none" required>
            <button type="submit" class="ml-2 px-4 py-2 bg-white-500 text-white rounded-lg hover:bg-blue-600">
                <i class="fa fa-search"></i>
            </button>
            </form>
            @auth
            <div class="flex items-center space-x-2">
                <a href="{{ route('cart.index') }}" class="px-2 py-2 bg-blue-500 rounded-lg hover:bg-green-600">
                    <i class="fa fa-shopping-cart"></i>
                </a>
                <a href="{{ route('items.create') }}" class="px-2 py-2 bg-blue-500 rounded-lg hover:bg-yellow-600">
                    <i class="fa fa-plus-circle"></i>
                </a>
                <a href="{{ route('items.index') }}" class="px-2 py-2 bg-blue-500 rounded-lg hover:bg-red-600">
                    <i class="fa fa-envelope"></i>
                </a>
            </div>
            @else
            <div class="flex items-center space-x-2">
                <a href="{{ route('login') }}" class="px-2 py-2 bg-blue-500 rounded-lg hover:bg-green-600">
                    <i class="fa fa-shopping-cart"></i>
                </a>
                <a href="{{ route('login') }}" class="px-2 py-2 bg-blue-500 rounded-lg hover:bg-yellow-600">
                    <i class="fa fa-plus-circle"></i>
                </a>
                <a href="{{ route('login') }}" class="px-2 py-2 bg-blue-500 rounded-lg hover:bg-red-600">
                    <i class="fa fa-envelope"></i>
                </a>
            </div>
            @endauth
            <!-- Auth Links -->
            <div class="hidden sm:flex sm:items-center">
                @auth
                <div class="relative" x-data="{ isOpen: false }">
                    <button @click="isOpen = !isOpen" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 focus:outline-none">
                        {{ Auth::user()->student_number }} <!-- change to id later maybe? ask feedback etc?-->
                    </button>

                    <!-- Dropdown Menu -->
                    <div x-show="isOpen" @click.away="isOpen = false" class="absolute right-0 mt-2 py-2 w-48 bg-white rounded-md shadow-xl z-20">
                        <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm capitalize text-gray-700 hover:bg-blue-500 hover:text-white">
                            Manage Account
                        </a>
                        <a href="{{ route('items.index') }}" class="block px-4 py-2 text-sm capitalize text-gray-700 hover:bg-blue-500 hover:text-white">
                            Your Orders
                        </a>
                        <a href="{{ route('items.index') }}" class="block px-4 py-2 text-sm capitalize text-gray-700 hover:bg-blue-500 hover:text-white">
                            Liked Items
                        </a>
                        <a href="{{ route('items.index') }}" class="block px-4 py-2 text-sm capitalize text-gray-700 hover:bg-blue-500 hover:text-white">
                            Your Reviews
                        </a>
                        <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="block px-4 py-2 text-sm capitalize text-gray-700 hover:bg-blue-500 hover:text-white">
                            Logout
                        </a>
                    </div>
                </div>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                    @csrf
                </form>

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
            &copy; {{ date('Y') }} {{ config('app.name', 'WunderSale') }}.
        </div>
    </footer>
</body>
</html>
