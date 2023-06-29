<?php

namespace App\Http\Controllers\API\payment;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Stripe;

class StripePaymentController extends Controller
{
    public function pay(Request $request)
    {
        try {
            $stripe = new \Stripe\StripeClient(
                env('STRIPE_SECRET')
            );
            $res = $stripe->tokens->create([
                'card' => [
                    'number' => $request->number,
                    'exp_month' => $request->exp_month,
                    'exp_year' => $request->exp_year,
                    'cvc' => $request->cvc,
                ],
            ]);
            Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

            $response = $stripe->charges->create([
                'amount' => $request->amount,
                'currency' => 'usd',
                'source' => $res->id,
                'description' => $request->description,
            ]);
            return response()->json([
                'message' => $response->status,
            ], 201);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }
}
