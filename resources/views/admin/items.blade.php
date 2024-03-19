@extends('layouts.admin_layout')

@section('content')
<div class="container">
    <h1 class="text-black font-bold mb-4">Manage Items</h1>
    <table class="min-w-full leading-normal">
        <thead>
            <tr>
                <th class="text-black">Item Name</th>
                <th class="text-black">Uploaded By</th>
                <th class="text-black">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($items as $item)
            <tr>
                <td class="text-black">{{ $item->name }}</td>
                <td class="text-black">{{ $item->user->name }}</td>
                <td>
                    <a href="{{ route('items.edit', $item->id) }}" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-700">Update</a>
                    <form action="{{ route('items.destroy', $item->id) }}" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-700">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
