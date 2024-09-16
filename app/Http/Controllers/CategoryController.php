<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Item;

class CategoryController extends Controller
{
  
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);
    
        Category::create([
            'name' => $request->input('name'),
        ]);
    
        return redirect()->back()->with('success', 'Category added successfully!');
    }
        public function index()
    {
        $categories = Category::all();
        $items = Item::all();

        return view('items.shop', compact('items', 'categories'));
    }
    

    public function showItems($id)
{
    $category = Category::findOrFail($id);
    $items = Item::where('category_id', $id)->get();
    $items = Item::where('category_id', $id)->paginate(12);


    return view('items.shop', compact('items', 'category'));
}

}
