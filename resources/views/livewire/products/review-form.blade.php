<?php

use App\Livewire\Forms\ReviewForm;
use App\Models\Product;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\On;
use Livewire\Volt\Component;

new class extends Component {
    public Product $product;

    public ReviewForm $form;

    #[On('updated-rating')]
    public function updateRating(int $rating): void
    {
        $this->form->rating = $rating;
    }

    public function send(): void
    {
        $this->form->validate();

        $review = $this->form->createReview($this->product->id);

        $this->dispatch('created-review');

        $this->form->reset('rating', 'body');
    }
}

?>

<x-card class="space-y-5">
    <div>
        <h3 class="text-xl font-medium">Create a review</h3>
        <p class="text-sm">Share your opinion so others can make use of that</p>
    </div>

    <form class="space-y-4" wire:submit="send">
        <livewire:products.rating-input wire:model="form.rating" />

        <x-textarea wire:model="form.body" rows="3" />

        <x-button primary label="Save" type="submit" />
    </form>
</x-card>

