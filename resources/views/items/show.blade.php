@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- product -->
    <div class="bg-white shadow-lg rounded-lg overflow-hidden mb-8">
        <div class="md:flex">
            <!-- image -->
            <div class="md:w-1/2">
                <img src="{{ $item->image ? asset('storage/' . $item->image) : 'https://via.placeholder.com/350x150' }}" alt="{{ $item->name }}" class="object-cover w-full h-full">
            </div>

            <!-- details -->
            <div class="md:w-1/2 p-4 text-gray-900">
                <h2 class="text-2xl font-bold mb-1">{{ $item->name }}</h2>
                <p class="mb-3">₱{{ number_format($item->price, 2) }}</p>
                
                <!-- quantity -->
                <div class="mb-4 flex items-center">
                    <button onclick="decreaseQuantity()" class="px-2 py-1 text-lg border rounded">-</button>
                    <input type="number" id="quantity" name="quantity" value="1" min="1" max="99" class="mx-2 border text-center w-16">
                    <button onclick="increaseQuantity({{ $item->quantity }})" class="px-2 py-1 text-lg border rounded">+</button>
                </div>

                <div class="flex space-x-2 mb-4">
                    <button class="flex-1 px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-700">Buy Now</button>
                    <button class="flex-1 px-4 py-2 bg-green-500 text-white rounded hover:bg-green-700">Add to Cart</button>
                </div>

                <!-- seller -->
                <div class="bg-gray-100 p-4 rounded-lg flex justify-between items-center">
                    <h3 class="text-lg font-semibold">
                        Sold by: <br><a href="{{ route('profile.show', $item->user->id) }}" class="font-semibold hover:underline">{{ $item->user->name }}</a>
                    </h3><!-- CRITICAL change to actual route thank you -->
                    
                    <!-- CRITICAL change to actual route thank you -->
                    <a href="{{ route('messages.create', ['recipient_id' => $item->user->id]) }}" class="hover:text-gray-600">
                        <i class="fas fa-comment-dots fa-lg"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    


    <!-- description  -->
    <div class="bg-white shadow-lg rounded-lg overflow-hidden p-4 text-gray-900">
        <h3 class="text-xl font-bold mb-4">Description</h3>
        <p>{{ $item->description }}</p>
    </div>

    <!-- items block -->
    <div class="bg-white shadow-lg rounded-lg overflow-hidden mb-8 p-4 text-gray-900">
        <h3 class="text-xl font-bold mb-4">You might also like</h3>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            @foreach($randomItems as $randomItem)
                <div class="border rounded-lg overflow-hidden shadow-lg hover:shadow-xl transition-shadow duration-300 ease-in-out">
                    <a href="{{ route('items.show', $randomItem->id) }}">
                        <img src="{{ $randomItem->image ? asset('storage/' . $randomItem->image) : 'https://via.placeholder.com/150' }}" alt="{{ $randomItem->name }}" class="w-full h-32 object-cover">
                        <div class="p-4">
                            <p class="text-gray-800">{{ $randomItem->name }}</p>
                            <p>₱{{ number_format($randomItem->price, 2) }}</p>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</div>

<script>
function increaseQuantity() {
    let quantityInput = document.getElementById('quantity');
    let currentValue = parseInt(quantityInput.value);
    if (currentValue < 99) {
        quantityInput.value = currentValue + 1;
    }
}

function decreaseQuantity() {
    let quantityInput = document.getElementById('quantity');
    let currentValue = parseInt(quantityInput.value);
    if (currentValue > 1) {
        quantityInput.value = currentValue - 1;
    }
}
</script>

</script>
@endsection
