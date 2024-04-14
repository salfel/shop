<?php

use App\Models\Cart;
use App\Models\CartProduct;
use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use JetBrains\PhpStorm\NoReturn;
use Livewire\Attributes\On;
use Livewire\Volt\Component;

new class extends Component {
    public Collection $products;
    public Cart $cart;
    public float $total;

    public function mount(Cart $cart): void
    {
        $this->products = $cart->products;

        $this->setAmount();
    }

    public function removeProduct(int $pivotId): void
    {
        CartProduct::find($pivotId)->delete();

        $this->products = $this->cart->products()->get();

        $this->setAmount();
    }

    #[NoReturn] #[On('updated-cart')]
    public function setAmount(): void
    {
        $this->total = CartProduct::where('cart_id', $this->cart->id)
            ->join('products', 'cart_product.product_id', '=', 'products.id')
            ->select(DB::raw('SUM(cart_product.amount * products.price) as total_price'))
            ->first()
            ->total_price ?? 0;
    }
}

?>

<div>
        @if ($products->isEmpty())
            <p>No products are in your cart yet</p>
        @else
            <table class="w-full">
                <tr class="[&>th]:text-start mb-2">
                    <th>Name</th>
                    <th>Price</th>
                    <th>Amount</th>
                    <th>Total</th>
                </tr>
                @foreach($products as $product)
                    <livewire:cart.product-row :product="$product" :key="$product->id"/>
                @endforeach
            </table>

            <div class="flex justify-between items-center mt-6">
                <a href="{{ route("checkout") }}">
                    <x-button primary label="Checkout" />

                </a>

                <span class="text-end text-lg font-medium mt-3">Total: {{ $total }}</span>
            </div>
        @endif
</div>

