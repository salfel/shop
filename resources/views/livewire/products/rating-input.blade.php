<?php

use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Modelable;
use Livewire\Attributes\On;
use Livewire\Volt\Component;

new class extends Component {
    #[Modelable]
    public int $value = 1;

    public function updateRating(int $value): void
    {
        $this->value = $value;
    }
}

?>

<div class="flex gap-1">
    @foreach(range(1, 5) as $i)
        <button wire:click="updateRating({{ $i }})" type="button" wire:key="{{ $i }}">
            <x-icon name="star" class="size-5 text-yellow-500" solid="{{ $i <= $value }}"/>
        </button>
    @endforeach
</div>
