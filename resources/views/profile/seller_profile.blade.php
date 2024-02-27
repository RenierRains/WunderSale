@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-xl mx-auto text-black">
        <h2 class="text-2xl font-bold mb-4">{{ $user->name }}</h2>
        <p>Email: {{ $user->email }}</p>
        <p>Student Number: {{ $user->student_number }}</p>
        
        <!-- Items Uploaded by the Seller -->
        <div class="mt-8">
            <h3 class="text-xl font-bold mb-4">Products:</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @forelse ($items as $item)
                    <div class="border rounded-lg overflow-hidden shadow-lg hover:shadow-xl transition-shadow duration-300 ease-in-out p-4">
                        <a href="{{ route('items.show', $item->id) }}">
                            <img src="{{ $item->image ? asset('storage/' . $item->image) : 'https://via.placeholder.com/150' }}" alt="{{ $item->name }}" class="w-full h-32 object-cover mb-2">
                            <div>
                                <p class="font-semibold">{{ $item->name }}</p>
                                <p>₱{{ number_format($item->price, 2) }}</p>
                            </div>
                        </a>
                    </div>
                @empty
                    <p class="text-grey-600" >No items uploaded yet.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
