<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Laravel\Cashier\Http\Controllers\WebhookController as CashierController;

class WebhookController extends CashierController
{
    public function handleCheckoutSessionCompleted($payload)
    {
        $email = $payload['data']['object']['customer_details']['email'];

        $user = User::where('email', $email)->first();

        $user->cart->products()->detach();

        return response('success');
    }
}
