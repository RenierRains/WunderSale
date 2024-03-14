<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cart; 
use App\Models\Order; 
use App\Models\OrderItem; 

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    public function finalizeCheckout(Request $request){
        $user = auth()->user();
    
        // selected_items from cart
        $selectedItemIds = $request->input('selected_items', []);
        $cartItems = Cart::where('user_id', $user->id)
                         ->whereIn('id', $selectedItemIds)
                         ->get();
    
        if ($cartItems->isEmpty()) {
            return back()->withErrors(['error' => 'No items selected for checkout.']);
        }
    
        //price
        $totalPrice = $cartItems->sum(function ($cartItem) {
            return $cartItem->quantity * $cartItem->item->price; 
        });
    
        $paymentMethod = $request->input('payment_method', 'Cash on Campus'); // default 2nd parameter

        // create order
        $order = Order::create([
            'user_id' => $user->id,
            'total_price' => $totalPrice,
            'status' => 'pending',
            'payment_method' => $paymentMethod, 
        ]);
        // generate order number
        $orderNumber = 'ORD-' . now()->year . '-' . Str::padLeft($order->id, 6, '0');
        $order->update(['order_number' => $orderNumber]);
    
        foreach ($cartItems as $cartItem) {
            OrderItem::create([
                'order_id' => $order->id,
                'item_id' => $cartItem->item_id,
                'quantity' => $cartItem->quantity,
                'price' => $cartItem->item->price, 
            ]);
    
            //decrement quantity and delete from cart + k maybe revamp this
            $cartItem->item->decrement('quantity', $cartItem->quantity);
            $cartItem->delete();
        }
    
        $order = $order->load('items.item');

        return redirect()->route('orders.thankyou')->with('orderDetails', $order);
    }
    

    public function previewCheckout(Request $request){
        \Log::info('Received selected_items:', $request->input('selected_items', []));
        $selectedItemIds = $request->input('selected_items', []);
        $cartItems = Cart::whereIn('id', $selectedItemIds)->with('item')->get();
    
        $totalPrice = $cartItems->sum(function ($cartItem) {
            return $cartItem->quantity * $cartItem->item->price;
        });
        return view('checkout.preview', compact('cartItems', 'totalPrice'));
    }

    public function userOrders(){
        $orders = Order::where('user_id', Auth::id())
                ->with(['items' => function ($query) {
                    $query->with('item')->take(10); 
                }])
                ->orderBy('created_at', 'desc')
                ->paginate(10); // paginate test

         return view('orders.user_orders', compact('orders'));
    }
    

}