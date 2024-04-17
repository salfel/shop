<?php

use App\Models\Favourite;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Livewire\Volt\Component;

new class extends Component {
    public Product $product;

    public bool $isFavourite;

    public function mount(): void
    {
        $this->setFavourite();
    }

    public function setFavourite(): void
    {
        $this->isFavourite = Auth::user()->whereRelation('favourites', 'product_id', $this->product->id)->exists();
    }

    public function favor(): void
    {
        if (!Auth::check()) {
            $this->redirectRoute('login', navigate: true);
            return;
        }

        $data = ['user_id' => Auth::id(), 'product_id' => $this->product->id];

        if ($this->isFavourite) {
            Favourite::where($data)->delete();
        } else {
            Favourite::create($data);
        }

        $this->setFavourite();
    }
}

?>

<div>
    @auth
        <x-button.circle wire:click="favor" secondary size="lg">
            <x-icon name="heart" solid="{{ $isFavourite }}" class="size-6 text-red-500" />
        </x-button.circle>
    @endauth
</div>

