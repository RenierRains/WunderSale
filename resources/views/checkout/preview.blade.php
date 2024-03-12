@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8">
    <div class="max-w-3xl mx-auto">
        <h2 class="text-2xl font-bold text-black mb-6">Checkout Details</h2>
        
        <div class="mb-8">
            <h3 class="text-xl font-semibold mb-4">Review Your Order</h3>
            <ul class="mb-6">
                @foreach ($cartItems as $cartItem)
                    <li class="mb-4 p-4 shadow rounded-lg flex justify-between items-center">
                        <div>
                            <h4 class="text-lg font-medium">{{ $cartItem->item->name }}</h4>
                            <p class="text-gray-600">Quantity: {{ $cartItem->quantity }}</p>
                        </div>
                        <p class="text-lg font-semibold">₱{{ number_format($cartItem->item->price * $cartItem->quantity, 2) }}</p>
                    </li>
                @endforeach
            </ul>
            <p class="text-xl font-semibold">Total: ₱{{ $totalPrice }}</p>
        </div>

        <form action="{{ route('checkout.finalize') }}" method="POST" class="bg-white p-6 shadow rounded-lg">
            @csrf
            <h3 class="text-xl font-semibold mb-4">Select Payment and Delivery Method</h3>
            
            <!-- pass selected_items from cart as hidden inputs -->
            @foreach ($cartItems as $cartItem)
                <input type="hidden" name="selected_items[]" value="{{ $cartItem->id }}">
            @endforeach
            
            <div class="mb-4">
                <input type="radio" id="cashOnCampus" name="payment_method" value="Cash on Campus" checked>
                <label for="cashOnCampus" class="ml-2">Cash on Campus</label>
            </div>
            <div class="mb-4">
                <input type="radio" id="cashOnDelivery" name="payment_method" value="Cash on Delivery">
                <label for="cashOnDelivery" class="ml-2">Cash on Delivery</label>
            </div>

            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Confirm Checkout</button>
        </form>
    </div>
</div>
@endsection
