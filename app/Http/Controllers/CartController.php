<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class CartController extends Controller
{
    public function show(): View
    {
        $user = Auth::user();

        $cart = $user->cart()->with('products')->first();

        return view('cart', [
            'cart' => $cart,
        ]);
    }

    public function delete(): RedirectResponse
    {
        $user = Auth::user();

        $user->cart->products()->detach();

        return redirect()->route('home');
    }
}
