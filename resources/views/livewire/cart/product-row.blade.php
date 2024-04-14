<?php

use App\Models\CartProduct;
use App\Models\Product;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Support\Facades\Log;
use JetBrains\PhpStorm\NoReturn;
use Livewire\Volt\Component;

new class extends Component {
    public int $amount;
    public Product $product;
    public CartProduct $cartProduct;

    public function mount(Product $product): void
    {
        $this->amount = $product->pivot->amount;

        $this->cartProduct = CartProduct::where(['product_id' => $this->product->id, 'cart_id' => $product->pivot->cart_id])->first();
    }

    public function updateAmount(int $amount = null): void
    {
        if ($amount != null && $amount >= 1) {
            $this->amount = $amount;
        }

        $this->cartProduct->update(['amount' => $this->amount]);

        $this->dispatch('updated-cart');
    }
}

?>

<tr class="[&>td]:py-2">
    <td class="flex items-center gap-3">
        <img src="{{ $product->images[0] }}" alt="{{ $product->name }}" class="h-12"/>
        <a href="{{ route('products.show', ['product' => $product->id]) }}">
            <span>{{ $product->name }}</span>
        </a>
    </td>
    <td>€ {{ $product->price }}</td>
    <td>
        <div class="relative inline-flex items-center">
            <x-button size="xs" class="absolute z-10 border-none left-1" wire:click="updateAmount({{ $amount - 1  }})"
                      icon="minus" />

            <x-input min="1" class="w-28 h-8 text-center number-input" type="number" wire:model.live="amount"
                     wire:change="updateAmount"/>

            <x-button size="xs" class="absolute z-10 border-none right-1" wire:click="updateAmount({{ $amount + 1  }})"
                      icon="plus"/>
        </div>
    </td>
    <td class="w-32">€ {{ $product->price * $amount }}</td>
    <td>
        <x-dropdown icon="bars-3">
            <x-dropdown.header label="Settings">
                <x-dropdown.item icon="trash" wire:click="$parent.removeProduct({{ $product->id }}, {{ $cartProduct->id }})" label="Remove" />
            </x-dropdown.header>
        </x-dropdown>
    </td>
</tr>

