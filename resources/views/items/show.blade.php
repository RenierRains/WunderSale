@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-md mx-auto">
        <img src="{{ $item->image ? asset('storage/' . $item->image) : 'https://via.placeholder.com/350x150' }}" alt="{{ $item->name }}" class="w-full h-64 object-cover mb-4">
        <h2 class="text-2xl font-bold mb-2">{{ $item->name }}</h2>
        <p class="text-gray-800 mb-3">{{ $item->description }}</p>
        <p class="text-gray-600">Price: ${{ number_format($item->price, 2) }}</p>
        <!-- Additional here -->
    </div>
</div>
@endsection