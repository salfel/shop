<?php

use App\Models\CartProduct;
use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\On;
use Livewire\Volt\Component;

new class extends Component {
    public Collection $products;

    public function removeProduct(int $productId, int $pivotId): void
    {
        $this->products = $this->products->filter(fn(Product $product) => $product->id !== $productId);

        CartProduct::find($pivotId)->delete();
    }
}

?>

<table class="w-full">
    @if ($products->isEmpty())
        <p>No products are in your cart yet</p>
    @else
        <tr class="[&>th]:text-start mb-2">
            <th>Name</th>
            <th>Price</th>
            <th>Amount</th>
            <th>Total</th>
        </tr>
        @foreach($products as $product)
            <livewire:cart.product-row :product="$product" :key="$product->id"/>
        @endforeach
    @endif
</table>
