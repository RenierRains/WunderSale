@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8">
    <h1 class="text-xl text-black font-bold mb-4">Your Cart</h1>
    
    @if($carts->isEmpty())
        <div class="text-center">
            <p class="text-gray-600 mb-4">No items in your cart.</p>
            <a href="{{ route('items.index') }}" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-700">Continue Shopping</a>
        </div>
    @else
        <div class="flex flex-wrap -mx-4">
            @foreach ($carts as $cart)
                <div class="w-full sm:w-1/2 md:w-1/3 lg:w-1/4 p-4">
                    <div class="border rounded-lg overflow-hidden shadow-lg hover:shadow-xl transition-shadow duration-300 ease-in-out">
                        <img src="{{ $cart->item->image ? asset('storage/' . $cart->item->image) : 'https://via.placeholder.com/150' }}" alt="{{ $cart->item->name }}" class="w-full h-48 object-cover">
                        <div class="p-4 bg-white">
                            <a href="{{ route('items.show', $cart->item->id) }}" class="block text-lg font-semibold text-gray-800 hover:text-indigo-600 transition-colors duration-300">{{ $cart->item->name }}</a>
                            <p class="text-gray-600 mt-1">${{ number_format($cart->item->price, 2) }}</p>
                            <p class="text-gray-500 text-sm mt-2">{{ Str::limit($cart->item->description, 50) }}</p>
                            <!-- Add remove from cart button or functionality as needed -->
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
