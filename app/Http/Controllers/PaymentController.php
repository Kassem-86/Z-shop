<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\PaymentIntent;
use App\Models\Order; // Import the Order model
use App\Models\Cart;  // Import the Cart model

class PaymentController extends Controller
{
    public function show()
    {
        return view('payment');
    }

    public function process(Request $request)
    {
        $request->validate([
            'payment_method' => 'required|string',
            'payment_method_id' => 'nullable|string', // Only for card payments
            'item_id' => 'required|integer', // Ensure item_id is provided
        ]);

        // Retrieve the item ID from the request
        $itemId = $request->input('item_id');

        if ($request->payment_method === 'cash') {
            // Handle cash payment logic
            // Create an order in the database
            $order = new Order();
            $order->user_id = auth()->id(); // Assuming the user is authenticated
            $order->item_id = $itemId;
            $order->save();

            // Remove the item from the cart
            Cart::where('user_id', auth()->id())->where('item_id', $itemId)->delete();

            return redirect()->route('payment.success')->with('success', 'Order placed successfully! Pay in cash upon delivery.');
        }

        try {
            // Create a PaymentIntent with the order amount and currency
            $paymentIntent = PaymentIntent::create([
                'amount' => 1000, // Adjust this amount as necessary
                'currency' => 'usd',
                'payment_method' => $request->payment_method_id,
                'confirm' => true,
            ]);

            // If payment is successful, create an order
            $order = new Order();
            $order->user_id = auth()->id(); // Assuming the user is authenticated
            $order->item_id = $itemId;
            $order->save();

            // Remove the item from the cart
            Cart::where('user_id', auth()->id())->where('item_id', $itemId)->delete();

            // Redirect to the success page
            return redirect()->route('payment.success')->with('success', 'Order placed successfully!');
        } catch (\Exception $e) {
            // Handle the error
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function success()
    {
        return view('payment.success'); // Ensure this view exists
    }
}
