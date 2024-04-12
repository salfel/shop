<?php

use App\Models\CartProduct;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Livewire\Volt\Component;

new class extends Component {

    public int $id;

    public function addToCart(): void
    {
        $cart = Auth::user()->cart;

        CartProduct::create([
            'product_id' => $this->id,
            'cart_id' => $cart->id,
        ]);

        $this->redirectRoute('cart');
    }
}

?>

<x-button wire:click="addToCart" primary size="lg" label="Add to Cart" />
