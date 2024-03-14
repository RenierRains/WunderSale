@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8 mt-4">
    <div class="text-center mb-4">
        <h1 class="text-xl font-semibold">My Orders</h1>
        <p class="text-sm text-gray-600">Review your order history and details.</p>
    </div>

    {{-- Tab Links --}}
    <div class="mb-6 text-center">
        <a href="{{ route('orders.user', 'all') }}" class="px-4 py-2 {{ $status == 'all' ? 'bg-blue-500 text-white' : 'bg-gray-200 text-gray-800' }} rounded-lg mx-1">All</a>
        <a href="{{ route('orders.user', 'pending') }}" class="px-4 py-2 {{ $status == 'pending' ? 'bg-blue-500 text-white' : 'bg-gray-200 text-gray-800' }} rounded-lg mx-1">Pending</a>
        <a href="{{ route('orders.user', 'delivered') }}" class="px-4 py-2 {{ $status == 'delivered' ? 'bg-blue-500 text-white' : 'bg-gray-200 text-gray-800' }} rounded-lg mx-1">Delivered</a>
    </div>

    {{-- Orders List --}}
    @forelse ($orders as $order)
        <div class="mb-4 p-3 bg-white shadow-sm rounded-lg">
            <div class="flex justify-between items-center border-b pb-2 mb-2">
                <h2 class="text-md font-medium">Order #{{ $order->order_number }}</h2>
                <span class="px-2 py-0.5 rounded-full text-xs font-medium {{ $order->status === 'pending' ? 'bg-yellow-200 text-yellow-800' : 'bg-green-200 text-green-800' }}">{{ ucfirst($order->status) }}</span>
            </div>
            <p class="text-xs mb-1">Placed on: <span class="font-semibold">{{ $order->created_at->format('M d, Y') }}</span></p>
            <p class="text-xs mb-1">Payment Method: <span class="font-semibold">{{ $order->payment_method }}</span></p>
            <p class="text-xs mb-2">Total: <span class="font-semibold">₱{{ number_format($order->total_price, 2) }}</span></p>

            <h3 class="text-sm font-medium mb-1">Items:</h3>
            <div class="grid grid-cols-2 gap-2">
                @foreach ($order->items->take(10) as $item)
                    <div class="flex items-center space-x-2 p-2 bg-gray-100 rounded">
                        <img src="{{ $item->item->image ? asset('storage/' . $item->item->image) : 'https://via.placeholder.com/40' }}" alt="{{ $item->item->name }}" class="h-10 w-10 object-cover rounded-md">
                        <div>
                            <p class="text-xs font-semibold">{{ $item->item->name }}</p>
                            <p class="text-xs text-gray-600">Qty: {{ $item->quantity }}</p>
                            <p class="text-xs text-gray-600">₱{{ number_format($item->price, 2) }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @empty
        <div class="text-center py-4">
            <p class="text-gray-600 font-medium">You have no orders in this category.</p>
        </div>
    @endforelse
</div>
{{ $orders->links() }}
@endsection
