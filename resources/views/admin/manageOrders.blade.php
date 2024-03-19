@extends('layouts.admin_layout')

@section('content')
<div class="container">
    <h1 class="text-black font-bold mb-4">Manage Orders</h1>
    
    <form action="{{ route('admin.orders') }}" method="GET" class="mb-4">
        <div class="flex space-x-2">
            <input type="text" name="search" placeholder="Search orders..." class="px-4 py-2 border rounded" value="{{ request('search') }}">
            <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-700">Search</button>
        </div>
    </form>
    
    <table class="min-w-full leading-normal">
        <thead>
            <tr>
                <th class="text-black">Order Number</th>
                <th class="text-black">Total Price</th>
                <th class="text-black">Status</th>
                <th class="text-black">Payment Method</th>
                <th class="text-black">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($orders as $order)
            <tr>
                <td class="text-black">{{ $order->order_number }}</td>
                <td class="text-black">₱{{ $order->total_price }}</td>
                <td class="text-black">{{ $order->status }}</td>
                <td class="text-black">{{ $order->payment_method }}</td>
                <td>
                    
                    <a href="#" class="px-4 py-2 bg-green-500 text-white rounded hover:bg-green-700">View</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
