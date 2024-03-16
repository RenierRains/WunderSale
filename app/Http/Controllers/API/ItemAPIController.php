<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

use App\Models\Item;
use App\Models\Category;

use Illuminate\Support\Facades\Gate;

class ItemAPIController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    // Return items and categories in JSON
    public function index()
    {
        $categories = Category::all();
        $items = Item::inRandomOrder()->take(8)->get();
        return response()->json(['categories' => $categories, 'items' => $items]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'description' => 'required',
            'price' => 'required|numeric',
            'category_id' => 'required|exists:categories,id',
            'quantity' => 'required|integer|min:1',
            'image' => 'nullable|image|max:2048',
        ]);

        $data = $request->only(['name', 'description', 'price', 'category_id', 'quantity']);
        $data['user_id'] = Auth::id();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('items', 'public');
        }

        $item = Item::create($data);

        return response()->json(['message' => 'Item created successfully.', 'item' => $item], Response::HTTP_CREATED);
    }

    public function update(Request $request, Item $item)
    {
        if (!Gate::allows('update-item', $item)) {
            return response()->json(['message' => 'Unauthorized'], Response::HTTP_FORBIDDEN);
        }

        $request->validate([
            'name' => 'sometimes|max:255',
            'description' => 'sometimes|required',
            'price' => 'sometimes|numeric',
            'category_id' => 'sometimes|required|exists:categories,id',
            'quantity' => 'sometimes|required|integer|min:1',
            'image' => 'nullable|image|max:2048',
        ]);

        $data = $request->only(['name', 'description', 'price', 'category_id', 'quantity']);

        if ($request->hasFile('image')) {
            if ($item->image) {
                Storage::delete($item->image);
            }
            $data['image'] = $request->file('image')->store('items', 'public');
        }

        $item->update($data);

        return response()->json(['message' => 'Item updated successfully.', 'item' => $item]);
    }

    public function destroy(Item $item)
    {
        if (!Gate::allows('delete-item', $item)) {
            return response()->json(['message' => 'Unauthorized'], Response::HTTP_FORBIDDEN);
        }

        if ($item->image) {
            Storage::delete($item->image);
        }

        $item->delete();

        return response()->json(['message' => 'Item deleted successfully.']);
    }

    public function userItems()
    {
        $items = Auth::user()->items;

        return response()->json(['items' => $items]);
    }

}