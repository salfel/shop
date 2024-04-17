<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Response;
use Laravel\Cashier\Http\Controllers\WebhookController as CashierController;

class WebhookController extends CashierController
{
    /**
     * @param  array<string, array<string, array<string, array<string, string>>>>  $payload
     */
    public function handleCheckoutSessionCompleted(array $payload): Response
    {
        $email = $payload['data']['object']['customer_details']['email'];

        $user = User::where('email', $email)->first();

        $products = $user->cart->products;
        $products->each(function (Product $product) {
            $product->update([
                'quantity' => $product->quantity - $product->pivot->amount,
            ]);
        });

        $user->cart->products()->detach();

        return response('success');
    }
}
