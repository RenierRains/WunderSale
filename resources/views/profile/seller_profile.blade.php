@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto bg-white p-6 rounded-lg shadow">
        <div class="mb-6">
            <h2 class="text-2xl font-bold text-gray-900 mb-4">{{ $user->name }}</h2>
            <div class="flex items-center text-gray-600 mb-2">
                <i class="fas fa-envelope mr-4"></i>
                <p>{{ $user->email }}</p>
            </div>
            <div class="flex items-center text-gray-600">
                <i class="fas fa-id-badge mr-4"></i>
                <p>{{ $user->student_number }}</p>
            </div>
        </div>
        
        <!-- Products Section -->
        <h3 class="text-xl font-bold text-gray-900 mb-4">Products:</h3>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            @forelse ($items as $item)
                <div class="border rounded-lg overflow-hidden shadow transition-shadow duration-300 ease-in-out hover:shadow-xl">
                    <a href="{{ route('items.show', $item->id) }}">
                        <img src="{{ $item->image ? asset('storage/' . $item->image) : 'https://via.placeholder.com/150' }}" alt="{{ $item->name }}" class="w-full h-48 object-cover">
                        <div class="p-4 bg-gray-100">
                            <p class="font-semibold text-gray-800">{{ $item->name }}</p>
                            <p class="text-gray-600">₱{{ number_format($item->price, 2) }}</p>
                        </div>
                    </a>
                </div>
            @empty
                <p class="text-gray-600">No items uploaded yet.</p>
            @endforelse
        </div>
    </div>
</div>
@endsection
