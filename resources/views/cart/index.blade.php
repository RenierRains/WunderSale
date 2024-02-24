@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8">
    <h1 class="text-xl text-black font-bold mb-4">Your Cart</h1>
    
    @if($carts->isEmpty())
        <div class="text-center">
            <p class="text-gray-600 mb-4">Your cart is empty.</p>
            <a href="{{ route('items.index') }}" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-700">Start Shopping</a>
        </div>
    @else
        <div class="flex flex-col">
            @foreach ($carts as $cart)
                <div class="flex flex-row justify-between items-center border-b py-4" id="cart-item-{{ $cart->id }}">
                    <div class="flex flex-row items-center">
                        <img src="{{ optional($cart->item)->image ? asset('storage/' . $cart->item->image) : 'https://via.placeholder.com/150' }}" alt="{{ optional($cart->item)->name }}" class="w-20 h-20 object-cover mr-4">
                        <div>
                            <a href="{{ optional($cart->item)->id ? route('items.show', $cart->item->id) : '#' }}" class="text-lg font-semibold text-gray-800 hover:text-indigo-600 transition-colors duration-300">{{ optional($cart->item)->name ?? 'Item not found' }}</a>
                            <p class="text-gray-600">₱{{ number_format(optional($cart->item)->price, 2) }}</p>
                        </div>
                    </div>
                    <div class="flex items-center">
                        <button onclick="changeQuantity('decrease', {{ $cart->id }})" class="px-2 py-1 text-lg bg-gray-300 text-gray-700 rounded hover:bg-gray-400">-</button>
                        <input type="text" value="{{ $cart->quantity }}" class="quantity-input mx-2 border text-center w-16 text-black" readonly data-cart-id="{{ $cart->id }}">
                        <button onclick="changeQuantity('increase', {{ $cart->id }})" class="px-2 py-1 text-lg bg-gray-300 text-gray-700 rounded hover:bg-gray-400">+</button>
                    </div>
                    <div>
                        <span class="text-lg text-black font-semibold total-price" data-cart-id="{{ $cart->id }}">Total: ₱{{ number_format($cart->total_price, 2) }}</span>
                    </div>
                    <button onclick="removeFromCart({{ $cart->id }})" class="remove-item-btn px-4 py-2 bg-red-500 text-white rounded hover:bg-red-700 transition duration-300">Remove</button>
                </div>
            @endforeach
        </div>
    @endif
</div>

<script>
function removeFromCart(cartId) {
    axios.post('/cart/remove', {
        cart_id: cartId,
        _token: "{{ csrf_token() }}"
    })
    .then(response => {
        // dynamic test
        const cartItemElement = document.getElementById(`cart-item-${cartId}`);
        cartItemElement.remove(); 
    })
    .catch(error => {
        console.error(error);
        alert('Failed to remove item from cart.');
    });
}
function changeQuantity(action, cartId) {
    axios.post('/cart/change-quantity', {
        action: action,
        cart_id: cartId,
        _token: "{{ csrf_token() }}"
    })
    .then(response => {
        // dynamic test 2
        const quantityInput = document.querySelector(`.quantity-input[data-cart-id="${cartId}"]`);
        const totalPriceElement = document.querySelector(`.total-price[data-cart-id="${cartId}"]`);

        quantityInput.value = response.data.quantity;
        totalPriceElement.innerHTML = `Total: ₱${response.data.total_price.toFixed(2)}`;
    })
    .catch(error => {
        console.error(error);
        alert('Failed to update quantity.');
    });

}
</script>
@endsection
