<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Checkout\Session;

class StripeController extends Controller
{
    public function index()
    {
        return view('payment');
    }

    public function checkout(Request $request)
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));

        try {
            $session = Session::create([
                "payment_method_types" => ['card'],
                "line_items" => [[
                    "price_data" => [
                        "currency" => "MYR",
                        "product_data" => [
                            "name" => "This payment is testing purpose of southern online",
                        ],
                        "unit_amount" => $request->sub * 100,
                    ],
                    "quantity" => 1,
                ]],
                "mode" => "payment",
                "success_url" => route('success'),
                "cancel_url" => route('payment'),
                "customer_email" => $request->email,
                "billing_address_collection" => 'required',
            ]);

            return redirect()->away($session->url);

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    public function success()
    {
        return view('payment');
    }
}
