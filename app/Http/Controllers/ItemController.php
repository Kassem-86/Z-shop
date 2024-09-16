<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Category;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    // Show all items
    public function index()
    {
        $items = Item::all();
        return view('admin.dashboard', compact('items'));
    }


    public function shop()
    {
        $items = Item::all();  // Fetch all items for users

        return view('items.shop', compact('items'));  // Return shop page view
    }
    // Show form to create a new item
    public function create()
    {
        $categories = Category::all(); // Get all categories
        return view('admin.add', compact('categories'));
    }

    // Store a new item
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'quantity' => 'required|integer',
            'category_id' => 'required|exists:categories,id',
            'picture' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
    
        $item = new Item();
        $item->name = $request->input('name');
        $item->price = $request->input('price');
        $item->quantity = $request->input('quantity');
        $item->category_id = $request->input('category_id');
    
        if ($request->hasFile('picture')) {
            $file = $request->file('picture');
            $path = $file->store('public/items');
            $item->image = str_replace('public/', '', $path); // Store relative path
        }
    
        $item->save();
    
        return redirect()->route('items.index')->with('success', 'Item added successfully');
    }
    
    // Show a single item
    public function show(Item $item)
    {
        return view('items.show', compact('item'));
    }

    // Show form to edit an item
    public function edit(Item $item)
    {
        $categories = Category::all(); // Get all categories
        return view('items.edit', compact('item', 'categories'));
    }

    // Update an item
public function update(Request $request, Item $item)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'category_id' => 'required|integer|exists:categories,id',
        'price' => 'required|numeric|min:0',
        'quantity' => 'required|integer|min:0',
    ]);

    $item->update([
        'name' => $request->name,
        'category_id' => $request->category_id,
        'price' => $request->price,
        'quantity' => $request->quantity,
    ]);

    return redirect()->route('items.index')->with('success', 'Item updated successfully.');
}

    // Delete an item
    public function destroy(Item $item)
    {
        $item->delete();
        return redirect()->route('items.index')->with('success', 'Item deleted successfully.');
    }
}
