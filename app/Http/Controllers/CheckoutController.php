<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Laravel\Cashier\Checkout;

class CheckoutController extends Controller
{
    public function __invoke(): Checkout
    {
        $user = Auth::user();

        $products = $user->cart->products;

        $data = [];

        foreach ($products as $product) {
            $data[$product->stripe_id] = $product->pivot->amount;
        }

        return $user->checkout($data, [
            'success_url' => route('home'),
            'cancel_url' => route('cart'),
        ]);
    }
}
