@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8">
    <div class="swiper-container my-4">
        <div class="swiper-wrapper">
            <div class="swiper-slide">
                <img src="{{ asset('storage/1.png') }}" alt="Image 1" class="w-full object-cover" style="height: 400px;">
            </div>
            <div class="swiper-slide">
                <img src="{{ asset('storage/2.png') }}" alt="Image 2" class="w-full object-cover" style="height: 400px;">
            </div>
        </div>
        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>
        <div class="swiper-pagination"></div>
    </div>
</div>

<div class="container mx-auto px-4 sm:px-6 lg:px-8">
    <h2 class="text-xl text-black font-bold my-4">NEW ARRIVALS!</h2>

    <div class="grid grid-cols-2 sm:grid-cols-4 md:grid-cols-5 lg:grid-cols-6 xl:grid-cols-8 gap-4">
        @foreach ($newArrivals as $item)
            <div class="max-w-xs">
                <div class="border overflow-hidden shadow-lg hover:shadow-xl transition-shadow duration-300 ease-in-out">
                    <a href="{{ route('items.show', $item->id) }}">
                        <img src="{{ $item->image ? asset('storage/' . $item->image) : 'https://via.placeholder.com/150' }}" alt="{{ $item->name }}" class="w-full h-32 object-cover">
                    </a>
                    <div class="p-4 bg-white">
                        <a href="{{ route('items.show', $item->id) }}" class="block text-md font-semibold text-gray-800 hover:text-indigo-600 transition-colors duration-300">{{ $item->name }}</a>
                        <p class="text-gray-600 mt-2 text-xs">₱{{ number_format($item->price, 2) }}</p>
                        <p class="text-gray-500 text-xs mt-2">{{ Str::limit($item->description, 30) }}</p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

<br>
<br>

<div class="container mx-auto px-4 sm:px-6 lg:px-8">
<h2 class="text-xl text-black font-bold mb-4">Categories</h2>
<div class="grid grid-cols-5 gap-0">
        @foreach ($categories as $category)

            <div class="max-w-xs border overflow-hidden bg-white">
                <a href="{{ route('search', ['query' => $category->name]) }}" class="flex flex-col items-center justify-center">
                    @php
                        $firstItemImage = $category->items->first() ? asset('storage/' . $category->items->first()->image) : 'https://via.placeholder.com/150';
                    @endphp
                    <div class="flex justify-center items-center h-24">
                        <img src="{{ $firstItemImage }}" alt="{{ $category->name }}" class="h-full w-auto object-contain">
                    </div>
                    <div class="px-2 py-1 text-center"> 
                        <span class="text-xs font-semibold text-gray-700">{{ $category->name }}</span>
                    </div>
                </a>
            </div>
        @endforeach
    </div>
</div>

<br>

<h2 class="text-xl text-black font-bold my-4">EXPLORE</h2>
    <div class="flex flex-wrap -mx-2">
        @foreach ($items as $item)
            <div class="p-2 w-1/2 sm:w-1/3 md:w-1/6">
                <div class="border rounded-lg overflow-hidden shadow-lg hover:shadow-xl transition-shadow duration-300 ease-in-out">
                    <a href="{{ route('items.show', $item->id) }}">
                        <img src="{{ $item->image ? asset('storage/' . $item->image) : 'https://via.placeholder.com/150' }}" alt="{{ $item->name }}" class="w-full h-32 object-cover">
                    </a>
                    <div class="p-2 bg-white">
                        <a href="{{ route('items.show', $item->id) }}" class="block text-md font-semibold text-gray-800 hover:text-indigo-600 transition-colors duration-300">{{ $item->name }}</a>
                        <div class="inline-block mt-1 py-0.5 px-2 bg-[#112D4E] text-white text-xs rounded-md">
                            {{ $item->category->name ?? 'No Category' }}
                        </div>
                        <p class="text-gray-600 text-xs mt-1">₱{{ number_format($item->price, 2) }}</p>
                        <p class="text-gray-500 text-xs">{{ Str::limit($item->description, 30) }}</p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    var swiper = new Swiper('.swiper-container', {
        loop: true,
        autoplay: {
            delay: 2500,
            disableOnInteraction: false,
        },
        spaceBetween: 50,
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
    });
});
</script>

@endsection
