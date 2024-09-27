<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Charge;
use Exception;

class StripeController extends Controller
{
    public function processPayment(Request $request)
    {
        // Validate the form inputs
        $request->validate([
            'card_number' => 'required|string',
            'expiry_date' => 'required|string',
            'cvv' => 'required|string',
            'payment_method' => 'required|string|in:visa',
        ]);

        // Extract expiry month and year
        $expiry = explode('/', $request->input('expiry_date'));
        $expiryMonth = trim($expiry[0]);
        $expiryYear = trim($expiry[1]);

        try {
            // Set your Stripe secret key
            Stripe::setApiKey(env('STRIPE_SECRET'));

            // Create a charge
            $charge = Charge::create([
                'amount' => 1000, // Amount in cents (e.g., $10.00)
                'currency' => 'usd',
                'source' => $request->input('stripeToken'), // Stripe token
                'description' => 'Payment for Order ID 1234',
            ]);

            return redirect()->route('payment.success')->with('success', 'Payment Successful!');
        } catch (Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}
