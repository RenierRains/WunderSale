<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Item;
use App\Http\Controllers\ItemController;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('query');
        // Simple search in the 'name' and 'description'.
        // Adjust query maybe later.
        $items = Item::where('name', 'LIKE', '%' . $query . '%')
                     ->orWhere('description', 'LIKE', '%' . $query . '%')
                     ->get();

        return view('search.results', compact('items'));
    }
}
