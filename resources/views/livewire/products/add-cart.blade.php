<?php

use App\Models\CartProduct;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use JetBrains\PhpStorm\NoReturn;
use Livewire\Volt\Component;
use WireUi\Traits\Actions;

new class extends Component {
    use Actions;

    public int $id;

    #[NoReturn] public function addToCart(): void
    {
        $cart = Auth::user()->cart;

        $cartProduct = CartProduct::where('product_id', $this->id)->where('cart_id', $this->id)->first();

        if ($cartProduct == null) {
            Log::info('Creating new cart product');
            CartProduct::create([
                'product_id' => $this->id,
                'cart_id' => $cart->id,
                'amount' => 1
            ]);
        } else {
            $cartProduct->update([
                'amount' => $cartProduct->amount + 1
            ]);
        }

        $this->notification([
            'title' => 'Product added to cart',
            'description' => 'The product has been added to your cart',
            'icon' => 'success'
        ]);
    }
}

?>

<x-button wire:click="addToCart" primary size="lg" label="Add to Cart"/>
