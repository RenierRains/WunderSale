@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8">
    <h1 class="text-xl font-semibold mb-4">Pending Orders</h1>
    @forelse ($orders as $order)
        <div class="mb-4 p-4 bg-white shadow rounded-lg">
            <div class="flex justify-between items-center">
                <div>
                    <h2 class="text-lg font-medium">Order #{{ $order->order_number }}</h2>
                    <p>Placed on: {{ $order->created_at->toFormattedDateString() }}</p>
                </div>
                <form action="{{ route('orders.confirmDeliveryBySeller', ['orderId' => $order->id]) }}" method="POST">
                    @csrf
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Mark as Delivered
                    </button>
                </form>
            </div>
        </div>
    @empty
        <p>You have no pending orders.</p>
    @endforelse
</div>
@endsection
