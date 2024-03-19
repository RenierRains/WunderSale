{{-- resources/views/layouts/admin_layout.blade.php --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard | {{ config('app.name', 'WunderSale') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="flex flex-col min-h-screen bg-gray-100 text-gray-800">
    <div class="flex">
        {{-- Sidebar --}}
        <aside class="w-64 bg-[#26214a] text-white h-screen">
            <div class="px-5 py-4">
                <a href="/" class="text-lg font-semibold">
                    <img src="{{ asset('storage/logo.png') }}" alt="{{ config('app.name', 'WunderSale') }}" class="h-10">
                </a>
            </div>
            <nav class="mt-5">
                <a href="{{ route('admin.users') }}" class="block py-2.5 px-4 rounded hover:bg-[#489331]">Manage Users</a>
                <a href="{{ route('admin.orders') }}" class="block py-2.5 px-4 rounded hover:bg-[#489331]">Manage Orders</a>
                <a href="{{ route('admin.items') }}" class="block py-2.5 px-4 rounded hover:bg-[#489331]">Manage Items</a>
            </nav>
        </aside>

        {{-- Main Content --}}
        <main class="flex-1">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
                @yield('content')
            </div>
        </main>
    </div>
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
</body>
</html>
