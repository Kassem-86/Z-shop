<?php
// app/Http/Controllers/CartController.php
namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function add(Request $request, Item $item)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1|max:' . $item->quantity, // Validating quantity
        ]);

        // Check if the item is already in the user's cart
        $cartItem = Cart::where('user_id', Auth::id())
            ->where('item_id', $item->id)
            ->first();

        if ($cartItem) {
            // Update the quantity if item is already in cart
            $cartItem->update([
                'quantity' => $cartItem->quantity + $request->quantity
            ]);
        } else {
            // Add the item to the cart
            Cart::create([
                'user_id' => Auth::id(),
                'item_id' => $item->id,
                'quantity' => $request->quantity,
            ]);
        }

        return back()->with('success', 'Item added to cart!');
    }

    public function show()
    {
        $cartItems = Cart::where('user_id', Auth::id())->with('item')->get();
        $totalPrice = $cartItems->sum(function($cartItem) {
            return $cartItem->item->price * $cartItem->quantity;
        });
        

        return view('cart', [
            'cartItems' => $cartItems,
            'totalPrice' => $totalPrice
        ]);
    }

    public function remove(Cart $cart)
    {
        // Check if the cart item belongs to the logged-in user
        if ($cart->user_id == Auth::id()) {
            $cart->delete();
        }

        return back()->with('success', 'Item removed from cart');
    }
}

