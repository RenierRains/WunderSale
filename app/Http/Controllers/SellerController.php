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
        // find
        $order = Order::findOrFail($orderId);

        // load
        $order->load('items.user');

        // check if seller sells
        $isSeller = $order->items->first(function ($item) {
            return $item->user_id === Auth::id();
        });

        if (!$isSeller) {
            //  authorize action
            return back()->withErrors(['message' => 'Unauthorized action.']);
        }

        // update to deleted
        $order->update(['status' => 'delivered']);

        // redirect
        return redirect()->route('seller.pendingOrders')->with('success', 'Order marked as delivered.');
    }
}
