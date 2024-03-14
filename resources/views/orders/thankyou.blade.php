@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="p-4 border-b">
            <h2 class="text-2xl font-bold text-green-600">Thank You for Your Order!</h2>
        </div>
        @if(session('orderDetails'))
            @php
                $order = session('orderDetails');
            @endphp
            <div class="p-4">
                <p class="text-lg">Your order has been successfully placed and is now being processed. Here are the details of your order:</p>

                <div class="mt-4">
                    <h3 class="text-lg font-semibold">Order Summary:</h3>
                    <ul class="list-disc pl-5">
                        @foreach ($order->items as $orderItem)
                            @php
                                $item = $orderItem->item; 
                            @endphp
                            @if($item)
                                <li>{{ $item->name }} - Quantity: {{ $orderItem->quantity }} - Price: ₱{{ $orderItem->price }}</li>
                            @else
                                <li>Item details not available</li>
                            @endif
                        @endforeach
                    </ul>
                    <p class="mt-2">Total: <strong>${{ $order->total_price }}</strong></p>
                </div>

                <div class="mt-4">
                    <h3 class="text-lg font-semibold">Payment Method:</h3>
                    <p>{{ $order->payment_method }}</p>
                </div>

                <div class="mt-4">
                    <h3 class="text-lg font-semibold">What's Next?</h3>
                    <p>You will receive an chat confirmation shortly. For Cash on Campus, please check your chat for further information.</p>
                </div>
            </div>
        @endif
        <div class="p-4 border-t">
            <a href="{{ route('home') }}" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-700">Continue Shopping</a>
        </div>
    </div>
</div>
@endsection
