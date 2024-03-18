<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Item;
use App\Models\Category;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\CategoryController;

class SearchController extends Controller
{
    public function index(Request $request){
        $query = $request->input('query');
        $minPrice = $request->input('min_price');
        $maxPrice = $request->input('max_price');
        $selectedCategories = $request->input('categories');

        $items = Item::query();


        if (!empty($selectedCategories)) {
            $items->whereIn('category_id', $selectedCategories);
        }

        if ($minPrice !== null) {
            $items->where('price', '>=', $minPrice);
        }
        if ($maxPrice !== null) {
            $items->where('price', '<=', $maxPrice);
        }

        if (!empty($query)) {
            $items->where(function ($q) use ($query) {
                $q->where('name', 'LIKE', '%' . $query . '%')
                  ->orWhere('description', 'LIKE', '%' . $query . '%')
                  ->orWhereHas('category', function ($q) use ($query) {
                      $q->where('name', 'LIKE', '%' . $query . '%');
                  });
            });
        }

        $items = $items->get();
        $categories = Category::all();

        return view('search.results', [
            'items' => $items,
            'categories' => $categories,
            'selectedCategories' => $selectedCategories,
            'minPrice' => $minPrice,
            'maxPrice' => $maxPrice,
            'query' => $query
        ]);
    }
}
