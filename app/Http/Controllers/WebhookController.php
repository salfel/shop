<?php

namespace App\Http\Controllers;

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

        $user->cart->products()->detach();

        return response('success');
    }
}
