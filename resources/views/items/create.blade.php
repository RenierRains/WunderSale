@extends('layouts.app')

@section('content')
<div class="container mx-auto p-8">
    <h1 class="text-2xl font-semibold text-gray-800 mb-6">List a New Item</h1>

    <form action="{{ route('items.store') }}" method="POST" enctype="multipart/form-data" class="w-full max-w-lg">
        @csrf
        <div class="mb-6">
            <label for="name" class="block text-gray-700 text-sm font-semibold mb-2">Name:</label>
            <input type="text" name="name" id="name" class="form-input mt-1 block w-full border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md" required>
        </div>

        <div class="mb-6">
            <label for="description" class="block text-gray-700 text-sm font-semibold mb-2">Description:</label>
            <textarea name="description" id="description" rows="4" class="form-textarea mt-1 block w-full border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md"></textarea>
        </div>

        <div class="mb-6">
            <label for="price" class="block text-gray-700 text-sm font-semibold mb-2">Price:</label>
            <input type="text" name="price" id="price" class="form-input mt-1 block w-full border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md" required>
        </div>

        <div class="mb-6">
            <label for="category_id" class="block text-gray-700 text-sm font-semibold mb-2">Category:</label>
            <select name="category_id" id="category_id" class="form-select mt-1 block w-full border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md">
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-6">
            <label for="quantity" class="block text-gray-700 text-sm font-semibold mb-2">Quantity:</label>
            <input type="number" name="quantity" id="quantity" class="form-input mt-1 block w-full border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md" min="1" value="1" required>
        </div>

        <div class="mb-6">
            <label for="image" class="block text-gray-700 text-sm font-semibold mb-2">Image:</label>
            <input type="file" name="image" id="image" class="form-input mt-1 block w-full border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md">
        </div>

        <button type="submit" class="px-4 py-2 bg-[#112D4E] text-white font-semibold rounded-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-600 focus:ring-opacity-50">Add Item</button>
    </form>
</div>
@endsection
