<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class CartController extends Controller
{
    public function __invoke(): View
    {
        $user = Auth::user();

        $cart = $user->cart()->with('products')->first();

        return view('cart', [
            'cart' => $cart,
        ]);
    }
}
