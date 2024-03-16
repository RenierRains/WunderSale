<?php

namespace App\Http\Controllers\API;
use App\Models\Cart;
use App\Model\Item;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartAPIController extends Controller
{
    public function index(Request $request){
        $user = Auth::user();

        if (!$user) {
            return response()->json(['message' => 'User not authenticated.'], 401);
        }

        $cartItems = Cart::where('user_id', $user->id)->with('item')->get();

        return response()->json([
            'message' => 'Cart items retrieved successfully.',
            'cartItems' => $cartItems,
        ]);
    }
    
    public function add(Request $request){
        $validated = $request->validate([
            'item_id' => 'required|exists:items,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $item = Item::find($validated['item_id']);
        $totalPrice = $item->price * $validated['quantity'];

        $cartItem = Cart::updateOrCreate(
            ['user_id' => Auth::id(), 'item_id' => $validated['item_id']],
            ['quantity' => $validated['quantity'], 'total_price' => $totalPrice]
        );

        return response()->json(['message' => 'Item added to cart successfully!', 'cartItem' => $cartItem]);
    }

    public function remove(Request $request)
    {
        $request->validate(['cart_id' => 'required|exists:carts,id']);

        $cart = Cart::where('id', $request->cart_id)->where('user_id', Auth::id())->first();
        if ($cart) {
            $cart->delete();
            return response()->json(['message' => 'Item removed successfully.']);
        }

        return response()->json(['message' => 'Item not found or not permitted to remove.'], 404);
    }

    public function changeQuantity(Request $request)
    {
        $cart = Cart::find($request->cart_id);
        if ($cart) {
            if ($request->action == 'increment') {
                $cart->quantity++;
            } elseif ($request->action == 'decrement') {
                $cart->quantity = $cart->quantity > 1 ? $cart->quantity - 1 : 1;
            }
            $cart->save();

            $totalPrice = $cart->quantity * $cart->item->price;
            return response()->json(['quantity' => $cart->quantity, 'total_price' => $totalPrice]);
        }

        return response()->json(['message' => 'Cart item not found.'], 404);
    }
}
