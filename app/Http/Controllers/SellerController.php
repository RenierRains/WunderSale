<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use App\Models\Order; 
use App\Models\OrderItem; 

class SellerController extends Controller
{
    public function pendingOrders()
    {
        $userId = Auth::id();
        $orderItems = OrderItem::whereHas('item', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })->whereHas('order', function ($query) {
            $query->where('status', 'pending');
        })->with('order')->get();

        $orders = $orderItems->pluck('order')->unique('id');

        return view('seller.pending_orders', compact('orders'));
    }

    public function confirmDeliveryBySeller(Request $request, $orderId)
{
    $order = Order::findOrFail($orderId);

    // Load the items of the order and the user (seller) of each item
    $order->load('items.item.user');

    // Check if the authenticated user is the seller of any items in this order
    $isSeller = $order->items->first(function ($item) {
        return $item->item->user_id === Auth::id();
    });

    if (!$isSeller) {
        return back()->withErrors(['message' => 'Unauthorized action.']);
    }

    $order->update(['status' => 'delivered']);

    return back()->with('success', 'Order marked as delivered.');
}

}
