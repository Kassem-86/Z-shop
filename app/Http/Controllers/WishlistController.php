<?php
// app/Http/Controllers/WishlistController.php
namespace App\Http\Controllers;

use App\Models\Wishlist;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    public function add(Request $request, Item $item)
    {
        // Check if the item is already in the user's wishlist
        $wishlistItem = Wishlist::where('user_id', Auth::id())
            ->where('item_id', $item->id)
            ->first();

        if ($wishlistItem) {
            return back()->with('info', 'Item is already in your wishlist!');
        }

        // Add the item to the wishlist
        Wishlist::create([
            'user_id' => Auth::id(),
            'item_id' => $item->id,
        ]);

        return back()->with('success', 'Item added to wishlist!');
    }
  public function show()
    {
        $wishlistItems = Wishlist::where('user_id', Auth::id())->with('item')->get();

        return view('wishlist', [
            'wishlistItems' => $wishlistItems
        ]);
    }

    public function remove(Wishlist $wishlist)
    {
        // Check if the wishlist item belongs to the logged-in user
        if ($wishlist->user_id == Auth::id()) {
            $wishlist->delete();
        }

        return back()->with('success', 'Item removed from wishlist');
    }
    
}
