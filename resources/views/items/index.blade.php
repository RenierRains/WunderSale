@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8">
    <h2 class="text-xl text-black font-bold mb-4">Categories</h2>
    <div class="flex flex-wrap -mx-2">
        @foreach ($categories as $category)
            <div class="p-2 w-1/2 sm:w-1/4 md:w-1/8">
                <div class="border rounded-lg overflow-hidden shadow-lg hover:shadow-xl transition-shadow duration-300 ease-in-out cursor-pointer">
                    <a href="{{ route('search', ['query' => $category->name]) }}">
                        <div class="p-4 bg-white">
                            <h3 class="text-md font-semibold text-gray-800 hover:text-indigo-600 transition-colors duration-300">{{ $category->name }}</h3>
                        </div>
                    </a>
                </div>
            </div>
        @endforeach
    </div>

    <h2 class="text-xl text-black font-bold my-4">EXPLORE</h2>
    <div class="flex flex-wrap -mx-2">
        @foreach ($items as $item)
            <div class="p-2 w-full sm:w-1/2 md:w-1/4">
                <div class="border rounded-lg overflow-hidden shadow-lg hover:shadow-xl transition-shadow duration-300 ease-in-out">
                    <a href="{{ route('items.show', $item->id) }}">
                        <img src="{{ $item->image ? asset('storage/' . $item->image) : 'https://via.placeholder.com/150' }}" alt="{{ $item->name }}" class="w-full h-48 object-cover">
                    </a>
                    <div class="p-4 bg-white">
                        <a href="{{ route('items.show', $item->id) }}" class="block text-lg font-semibold text-gray-800 hover:text-indigo-600 transition-colors duration-300">{{ $item->name }}</a>
                        <p class="text-gray-600 mt-1">₱{{ number_format($item->price, 2) }}</p>
                        <p class="text-gray-500 text-sm mt-2">{{ Str::limit($item->description, 50) }}</p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
