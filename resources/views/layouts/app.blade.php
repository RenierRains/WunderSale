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
        flex-direction: column-reverse; /* Newest messages at the bottom */
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
<body class="flex flex-col min-h-screen bg-white text-gray-800">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <header class="bg-[#26214a] shadow-md sticky top-0 z-50">
        <nav class="container mx-auto flex justify-between items-center p-4 text-white">
            <a href="/" class="text-lg font-semibold">
                <img src="{{ asset('storage/logo.png') }}" alt="WunderSale" class="h-20">
            </a>
            <!-- Search -->
            <div class="flex items-center flex-grow mx-4 bg-white border rounded-lg overflow-hidden">
            <form action="{{ route('search') }}" method="GET" class="w-full flex">
                <input type="text" name="query" placeholder="Search in WunderSale" class="pl-4 py-2 w-full focus:outline-none text-black border-none" required>
                <button type="submit" class="px-4 py-2 bg-[#ffcb19] text-gray-800 hover:bg-[#F9A602] border-none">
                    <i class="fa fa-search"></i>
                </button>
            </form>
            </div>
            @auth
            <div class="flex items-center space-x-4">
                <a href="{{ route('cart.index') }}" class="px-3 py-3 bg-[#489331] rounded-lg hover:bg-green-600 text-white"> 
                    <i class="fa fa-shopping-cart"></i>
                </a>
                <a href="{{ route('items.create') }}" class="px-3 py-3 bg-[#489331] rounded-lg hover:bg-green-600 text-white"> 
                    <i class="fa fa-plus-circle"></i>
                </a>
                <a href="{{ route('home') }}" class="px-3 py-3 bg-[#489331] rounded-lg hover:bg-green-600 text-white">
                    <i class="fa fa-envelope"></i>
                </a>
            </div>
            @else
            <div class="flex items-center space-x-4"> 
                <a href="{{ route('login') }}" class="px-3 py-3 bg-[#489331] rounded-lg hover:bg-green-600 text-white"> 
                    <i class="fa fa-shopping-cart"></i>
                </a>
                <a href="{{ route('login') }}" class="px-3 py-3 bg-[#489331] rounded-lg hover:bg-green-600 text-white"> 
                    <i class="fa fa-plus-circle"></i>
                </a>
                <a href="{{ route('login') }}" class="px-3 py-3 bg-[#489331] rounded-lg hover:bg-green-600 text-white"> 
                    <i class="fa fa-envelope"></i>
                </a>
            </div>
            @endauth
            <!-- Auth Links -->
            <div class="flex items-center mx-4">
                @auth
                <div class="relative space-x-4" x-data="{ isOpen: false }">
                    <button @click="isOpen = !isOpen" class="px-4 py-2 bg-[#489331] text-white rounded hover:bg-green-600 focus:outline-none">
                        {{ Auth::user()->student_number }}
                    </button>

                    <!-- Dropdown Menu -->
                    <div x-show="isOpen" @click.away="isOpen = false" class="absolute right-0 mt-2 py-2 w-48 bg-white rounded-md shadow-xl z-20">
                        <a href="{{ route('profile.show', Auth::user()->id) }}" class="block px-4 py-2 text-sm text-gray-800 hover:bg-green-500 hover:text-white">
                            My Profile
                        </a>
                        <a href="{{ route('items.user') }}" class="block px-4 py-2 text-sm capitalize text-gray-700 hover:bg-green-700 hover:text-white">
                            Your Products
                        </a>
                        <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm capitalize text-gray-700 hover:bg-green-700 hover:text-white">
                            Manage Account
                        </a>
                        <a href="{{ route('orders.user') }}" class="block px-4 py-2 text-sm capitalize text-gray-700 hover:bg-green-700 hover:text-white">
                            Your Orders
                        </a>
                        <a href="{{ route('home') }}" class="block px-4 py-2 text-sm capitalize text-gray-700 hover:bg-green-700 hover:text-white">
                            Liked Items
                        </a>
                        <a href="{{ route('home') }}" class="block px-4 py-2 text-sm capitalize text-gray-700 hover:bg-green-700 hover:text-white">
                            Your Reviews
                        </a>
                        <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="block px-4 py-2 text-sm capitalize text-gray-700 hover:bg-green-700 hover:text-white">
                            Logout
                        </a>
                    </div>
                </div>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                    @csrf
                </form>

                @else
                    <a href="{{ route('login') }}" class="text-sm font-semibold hover:text-gray-600">Log in</a>
                @endauth
            </div>
        </nav>
    </header>

    <main class="flex-grow">
        <div class="container mx-auto px-4 py-8">
        
            @yield('content')

        </div>
    </main>

    <footer class="bg-[#26214a] text-white text-center p-4 shadow-md">
        <div class="container mx-auto">
            &copy; {{ date('Y') }} {{ config('app.name', 'WunderSale') }}.
        </div>
    </footer>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</body>
</html>