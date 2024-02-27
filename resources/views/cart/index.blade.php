@extends('layouts.app')

@section('head')
<style>
    .order-summary {
        position: -webkit-sticky; /* Safari */
        position: sticky;
        top: 20px;
    }
</style>
@endsection

@section('content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8 flex flex-wrap">
    <div class="w-full lg:w-3/4 pr-4 mb-6">
        <h1 class="text-xl text-black font-bold mb-4">Your Cart</h1>
        
        @if($carts->isEmpty())
            <div class="text-center">
                <p class="text-gray-600 mb-4">Your cart is empty.</p>
                <a href="{{ route('items.index') }}" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-700">Start Shopping</a>
            </div>
        @else
            <form id="cart-form">
                @csrf
                @foreach ($carts as $cart)
                    <div class="flex justify-between items-center border-b py-4" id="cart-item-{{ $cart->id }}">
                        <div class="flex items-center">
                            <input type="checkbox" name="selected_items[]" value="{{ $cart->id }}" class="item-checkbox mr-4" data-cart-id="{{ $cart->id }}" data-price="{{ $cart->total_price }}" onchange="updateTotal()">
                            <img src="{{ optional($cart->item)->image ? asset('storage/' . $cart->item->image) : 'https://via.placeholder.com/150' }}" alt="{{ optional($cart->item)->name }}" class="w-20 h-20 object-cover mr-4">
                            <div>
                                <a href="{{ optional($cart->item)->id ? route('items.show', $cart->item->id) : '#' }}" class="text-lg font-semibold text-gray-800 hover:text-indigo-600 transition-colors duration-300">{{ optional($cart->item)->name ?? 'Item not found' }}</a>
                                <p class="text-gray-600">₱{{ number_format(optional($cart->item)->price, 2) }}</p>
                                <div class="flex items-center">
                                    <button type="button" onclick="changeQuantity('decrement', {{ $cart->id }})" class="px-2 py-1 bg-gray-300 text-gray-600 hover:bg-gray-400 rounded-l">-</button>
                                    <input type="text" class="quantity-input w-12 text-center bg-gray-100 border-none outline-none" value="{{ $cart->quantity }}" data-cart-id="{{ $cart->id }}" readonly>
                                    <button type="button" onclick="changeQuantity('increment', {{ $cart->id }})" class="px-2 py-1 bg-gray-300 text-gray-600 hover:bg-gray-400 rounded-r">+</button>
                                </div>
                            </div>
                        </div>
                        <div class="flex items-center">
                            <span class="total-price text-lg" data-cart-id="{{ $cart->id }}">₱{{ number_format($cart->total_price, 2) }}</span>
                            <button onclick="removeFromCart({{ $cart->id }})" class="ml-4 text-red-500 hover:text-red-700">
                                <i class="fa fa-times"></i>
                            </button>
                        </div>
                    </div>
                @endforeach
            </form>
        @endif
    </div>
    <div class="w-full lg:w-1/4 pl-4">
        <div class="order-summary">
            <div class="bg-white p-4 shadow rounded">
                <h2 class="text-lg font-bold mb-4">Order Summary</h2>
                <div class="mb-4">
                    <span class="text-gray-600">Total: ₱</span><span id="selected-total">0.00</span>
                </div>
                <button id="checkout-button" onclick="checkout()" class="w-full px-6 py-2 bg-green-500 text-white rounded hover:bg-green-700 disabled:opacity-50" disabled>Checkout</button>
            </div>
        </div>
    </div>
</div>

<script>
function removeFromCart(cartId) {
    axios.post('/cart/remove', {
        cart_id: cartId,
        _token: "{{ csrf_token() }}"
    })
    .then(response => {
        const cartItemElement = document.getElementById(`cart-item-${cartId}`);
        cartItemElement.remove(); 
        updateTotal();
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
        const quantityInput = document.querySelector(`.quantity-input[data-cart-id="${cartId}"]`);
        const totalPriceElement = document.querySelector(`.total-price[data-cart-id="${cartId}"]`);

        quantityInput.value = response.data.quantity;
        totalPriceElement.innerText = `₱${response.data.total_price.toFixed(2)}`;
        updateTotal(); 
    })
    .catch(error => {
        console.error(error);
        alert('Failed to update quantity.');
    });
}

function updateTotal() {
    let total = 0;
    document.querySelectorAll('.item-checkbox:checked').forEach((checkbox) => {
        total += parseFloat(checkbox.dataset.price);
    });

    document.getElementById('selected-total').innerText = total.toFixed(2);
    document.getElementById('checkout-button').disabled = !document.querySelectorAll('.item-checkbox:checked').length;
}

function checkout() {
    let selectedItems = Array.from(document.querySelectorAll('.item-checkbox:checked')).map(checkbox => checkbox.value);
    // AAAAAAAAAAAAAAAAAAAAAAAA GO ON???
}
</script>
@endsection
