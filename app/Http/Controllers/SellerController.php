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
        // Find the order
        $order = Order::findOrFail($orderId);

        // Load the order's items to verify if the current user (seller) is associated with this order
        $order->load('items.user');

        // Check if the authenticated user is the seller of any items in this order
        $isSeller = $order->items->first(function ($item) {
            return $item->user_id === Auth::id();
        });

        if (!$isSeller) {
            // If the user is not the seller of any items in the order, deny the action
            return back()->withErrors(['message' => 'Unauthorized action.']);
        }

        // Proceed to update the order status to 'delivered'
        $order->update(['status' => 'delivered']);

        // Redirect back with a success message
        return redirect()->route('seller.pendingOrders')->with('success', 'Order marked as delivered.');
    }
}
