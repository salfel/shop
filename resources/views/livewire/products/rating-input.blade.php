<?php

use Illuminate\Support\Facades\Log;
use Livewire\Attributes\On;
use Livewire\Volt\Component;

new class extends Component {
    public int $rating = 1;

    public function updateRating(int $rating): void
    {
        $this->rating = $rating;

        $this->dispatch('updated-rating', rating: $rating);
    }

    #[On('created-review')]
    public function resetRating(): void
    {
        $this->rating = 1;
    }
}

?>

<div class="flex gap-1">
    @foreach(range(1, 5) as $i)
        <button wire:click="updateRating({{ $i }})" type="button" wire:key="{{ $i }}">
            <x-icon name="star" class="size-5 text-yellow-500" solid="{{ $i <= $rating }}"/>
        </button>
    @endforeach
</div>
