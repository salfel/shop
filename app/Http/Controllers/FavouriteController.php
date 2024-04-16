<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class FavouriteController extends Controller
{
    public function __invoke()
    {
        $products = Auth::user()->favourites()->paginate(12);

        return view('favourites', [
            'products' => $products,
        ]);
    }
}
