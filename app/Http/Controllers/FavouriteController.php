<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class FavouriteController extends Controller
{
    public function __invoke(): View
    {
        $products = Auth::user()->favourites()->paginate(12);

        return view('favourites', [
            'products' => $products,
        ]);
    }
}
