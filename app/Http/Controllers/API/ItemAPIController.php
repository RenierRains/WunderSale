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
    // Return items and categories in JSON
    public function index()
    {
        $categories = Category::all();
        $items = Item::inRandomOrder()->take(8)->get();
        return response()->json(['categories' => $categories, 'items' => $items]);
    }

    // Handle item creation and return JSON response
    public function store(Request $request)
    {
        $validated = $request->validate([
            // Validation rules
        ]);

        // Assuming validation rules are defined as in the original method

        $item = Item::create($validated);
        if ($request->hasFile('image')) {
            $item->image = $request->file('image')->store('items', 'public');
            $item->save();
        }

        return response()->json(['message' => 'Item created successfully.', 'item' => $item], 201);
    }

    // Return a specific item in JSON
    public function show(Item $item)
    {
        $randomItems = Item::where('id', '!=', $item->id)->inRandomOrder()->take(4)->get(); 
        return response()->json(['item' => $item, 'randomItems' => $randomItems]);
    }

    // Handle item update and return JSON response
    public function update(Request $request, Item $item)
    {
        $validated = $request->validate([
            // Validation rules
        ]);

        // Assuming validation rules are defined as in the original method

        $item->update($validated);
        return response()->json(['message' => 'Item updated successfully.', 'item' => $item]);
    }

    // Handle item deletion and return JSON response
    public function destroy(Item $item)
    {
        $item->delete();
        return response()->json(['message' => 'Item deleted successfully.']);
    }
}