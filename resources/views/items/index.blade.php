@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex flex-wrap -mx-4">
        @foreach ($items as $item)
            <div class="w-full sm:w-1/2 md:w-1/3 lg:w-1/4 p-4">
                <div class="border rounded-lg overflow-hidden shadow-lg hover:shadow-xl transition-shadow duration-300 ease-in-out">
                    <a href="{{ route('items.show', $item->id) }}">
                        <img src="{{ $item->image ? asset('storage/' . $item->image) : 'https://via.placeholder.com/150' }}" alt="{{ $item->name }}" class="w-full h-48 object-cover">
                    </a>
                    <div class="p-4 bg-white">
                        <a href="{{ route('items.show', $item->id) }}" class="block text-lg font-semibold text-gray-800 hover:text-indigo-600 transition-colors duration-300">{{ $item->name }}</a>
                        <p class="text-gray-600 mt-1">${{ number_format($item->price, 2) }}</p>
                        <p class="text-gray-500 text-sm mt-2">{{ Str::limit($item->description, 50) }}</p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection