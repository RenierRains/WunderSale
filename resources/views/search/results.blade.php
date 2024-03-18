@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6 flex">
    <aside class="w-1/4 pr-4">
        <h2 class="text-xl font-bold mb-4">Filters</h2>
        
        <hr class="my-4 border-t border-gray-200">
        
        <section class="mb-6">
            <h3 class="font-semibold mb-2">Categories</h3>
            @foreach ($categories as $category)
                <a href="{{ route('search', ['categories' => [$category->id]]) }}" class="block p-2 hover:bg-blue-100 rounded transition-colors duration-300">
                    {{ $category->name }}
                </a>
            @endforeach
        </section>

        <hr class="my-4 border-t border-gray-200">

        <form method="GET" action="{{ route('search') }}" class="mb-6">
            <h3 class="font-semibold mb-2">Price Range</h3>
            <input type="hidden" name="query" value="{{ request()->query('query') }}">
            @if(request()->categories)
                @foreach(request()->categories as $category)
                    <input type="hidden" name="categories[]" value="{{ $category }}">
                @endforeach
            @endif
            <label class="block mb-2">
                Min Price:
                <input type="number" name="min_price" value="{{ request()->min_price }}" class="form-input mt-1">
            </label>
            <label class="block mb-4">
                Max Price:
                <input type="number" name="max_price" value="{{ request()->max_price }}" class="form-input mt-1">
            </label>
            <button type="submit" class="w-full bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Apply
            </button>
        </form>
    </aside>


    <div class="flex-grow">
        <div class="h-full w-px bg-gray-200 mx-4"></div>
    </div>

    <div class="w-3/4 p-4">
        <h1 class="text-xl text-black font-bold mb-4">Search Results</h1>
        @if($items->isNotEmpty())
            <div class="flex flex-wrap -mx-4">
                @foreach($items as $item)
                <div class="w-full sm:w-1/2 md:w-1/3 lg:w-1/4 p-4">
                    <div class="border rounded-lg overflow-hidden shadow-lg hover:shadow-xl transition-shadow duration-300 ease-in-out">
                        <a href="{{ route('items.show', $item->id) }}">
                            <img src="{{ $item->image ? asset('storage/' . $item->image) : 'https://via.placeholder.com/150' }}" alt="{{ $item->name }}" class="w-full h-48 object-cover">
                        </a>
                        <div class="p-4 bg-white">
                            <a href="{{ route('items.show', $item->id) }}" class="block text-lg font-semibold text-gray-800 hover:text-indigo-600 transition-colors duration-300">{{ $item->name }}</a>
                            <p class="text-gray-600 mt-1">₱{{ number_format($item->price, 2) }}</p>
                            <p class="text-gray-500 text-sm mt-2">{{ Str::limit($item->description, 50) }}</p>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        @else
            <p class="text-red-500">No items found.</p>
        @endif
    </div>
</div>
@endsection
