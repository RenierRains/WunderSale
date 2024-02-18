@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-xl text-black font-bold mb-4">Your Products</h1>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        @forelse ($items as $item)
            <div class="border rounded-lg p-4">
                <h2 class="text-lg text-black font-bold">{{ $item->name }}</h2>
                <p class="text-black">{{ $item->description }}</p>
                <div class="mt-4 flex justify-between items-center">
                    <a href="{{ route('items.edit', $item->id) }}" class="px-4 py-2 bg-blue-500 text-black rounded hover:bg-blue-700">Update</a>
                    <form action="{{ route('items.destroy', $item->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-4 py-2 bg-red-500 text-black rounded hover:bg-red-700">Delete</button>
                    </form>
                </div>
            </div>
        @empty
            <p>No products found.</p>
        @endforelse
    </div>
</div>
@endsection
