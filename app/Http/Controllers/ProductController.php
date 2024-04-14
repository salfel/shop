<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Models\Product;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ProductController extends Controller
{
    use AuthorizesRequests;

    public function index(): View
    {
        return view('products.index', [
            'products' => Product::paginate(12),
        ]);
    }

    public function show(Product $product): View
    {
        $reviews = $product->reviews()->with('user')->paginate(12, pageName: 'reviews_page');

        return view('products.show', [
            'product' => $product,
            'reviews' => $reviews,
        ]);
    }
}
