@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8">
    <div class="max-w-3xl mx-auto">
        <h2 class="text-2xl font-bold text-black mb-6">Direct Purchase Checkout</h2>

        <div class="mb-8">
            <h3 class="text-xl font-semibold mb-4">Review Your Direct Purchase</h3>
            <div class="mb-4 p-4 shadow rounded-lg flex justify-between items-center">
                <div>
                    <h4 class="text-lg font-medium">{{ $item->name }}</h4>
                    <p class="text-gray-600">Quantity: {{ $quantity }}</p>
                </div>
                <p class="text-lg font-semibold">₱{{ number_format($item->price * $quantity, 2) }}</p>
            </div>
            <p class="text-xl font-semibold">Total: ₱{{ number_format($item->price * $quantity, 2) }}</p>
        </div>

        <form action="{{ route('checkout.finalizeDirectPurchase') }}" method="POST" class="bg-white p-6 shadow rounded-lg">
            @csrf
            <input type="hidden" name="item_id" value="{{ $item->id }}">
            <input type="hidden" name="quantity" value="{{ $quantity }}">
            <h3 class="text-xl font-semibold mb-4">Select Payment and Delivery Method</h3>
            
            <div class="mb-4">
                <input type="radio" id="directCashOnCampus" name="payment_method" value="Cash on Campus" checked>
                <label for="directCashOnCampus" class="ml-2">Cash on Campus</label>
            </div>
            <div class="mb-4">
                <input type="radio" id="directCashOnDelivery" name="payment_method" value="Cash on Delivery">
                <label for="directCashOnDelivery" class="ml-2">Cash on Delivery</label>
            </div>

            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Confirm Purchase</button>
        </form>
    </div>
</div>
@endsection
