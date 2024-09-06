<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Checkout\Session;

class StripeController extends Controller
{
   

    public function checkout(Request $request)
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));

        try {
            
            $totalAmount = $request->input('total_amount');

            $totalAmountInCents = $totalAmount * 100;

            $session = Session::create([
                'payment_method_types' => ['card'],
                'line_items' => [[
                    'price_data' => [
                        'currency' => 'MYR',
                        'product_data' => [
                            'name' => 'Total Medication Cost',
                        ],
                        'unit_amount' => $totalAmountInCents, 
                    ],
                    'quantity' => 1,
                ]],
                'mode' => 'payment',
                'success_url' => route('nursePage'),
                'cancel_url' => route('nurseList'),
                'locale' => 'en',
            ]);

            return redirect()->away($session->url);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    public function success()
    {
        return view('nursePage');
    }
}
