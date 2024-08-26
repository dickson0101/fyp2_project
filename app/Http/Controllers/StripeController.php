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
            // 从请求中获取总金额
            $totalAmount = $request->input('total_amount');

            // 确保 total_amount 是以分为单位的
            $totalAmountInCents = $totalAmount * 100;

            $session = Session::create([
                'payment_method_types' => ['card'],
                'line_items' => [[
                    'price_data' => [
                        'currency' => 'MYR',
                        'product_data' => [
                            'name' => 'Total Medication Cost',
                        ],
                        'unit_amount' => $totalAmountInCents, // Stripe 需要以分为单位的金额
                    ],
                    'quantity' => 1,
                ]],
                'mode' => 'payment',
                'success_url' => route('success'),
                'cancel_url' => route('medications.list'),
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
