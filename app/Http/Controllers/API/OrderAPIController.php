<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class OrderAPIController extends Controller
{
    public function finalizeCheckout(Request $request)
    {
        $user = auth()->user();
        
        $selectedItemIds = $request->input('selected_items', []);
        $cartItems = Cart::where('user_id', $user->id)
                         ->whereIn('id', $selectedItemIds)
                         ->get();

        if ($cartItems->isEmpty()) {
            return response()->json(['error' => 'No items selected for checkout.'], 422);
        }

        $totalPrice = $cartItems->sum(function ($cartItem) {
            return $cartItem->quantity * $cartItem->item->price;
        });

        $paymentMethod = $request->input('payment_method', 'Cash on Campus');

        $order = Order::create([
            'user_id' => $user->id,
            'total_price' => $totalPrice,
            'status' => 'pending',
            'payment_method' => $paymentMethod,
        ]);

        $orderNumber = 'ORD-' . now()->year . '-' . Str::padLeft($order->id, 6, '0');
        $order->update(['order_number' => $orderNumber]);

        foreach ($cartItems as $cartItem) {
            OrderItem::create([
                'order_id' => $order->id,
                'item_id' => $cartItem->item_id,
                'quantity' => $cartItem->quantity,
                'price' => $cartItem->item->price,
            ]);

            $cartItem->item->decrement('quantity', $cartItem->quantity);
            $cartItem->delete();
        }

        $order = $order->load('items.item');

        return response()->json(['orderDetails' => $order]);
    }

    public function previewCheckout(Request $request)
    {
        Log::info('Received selected_items:', $request->input('selected_items', []));
        $selectedItemIds = $request->input('selected_items', []);
        $cartItems = Cart::whereIn('id', $selectedItemIds)->with('item')->get();

        $totalPrice = $cartItems->sum(function ($cartItem) {
            return $cartItem->quantity * $cartItem->item->price;
        });

        return response()->json(['cartItems' => $cartItems, 'totalPrice' => $totalPrice]);
    }

    public function userOrders()
    {
        $orders = Order::where('user_id', Auth::id())
                       ->with(['items' => function ($query) {
                           $query->with('item')->take(10);
                       }])
                       ->orderBy('created_at', 'desc')
                       ->paginate(10);

        return response()->json(['orders' => $orders]);
    }
}
