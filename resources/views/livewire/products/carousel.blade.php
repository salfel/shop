<?php

use Livewire\Volt\Component;

new class extends Component {

    public array $images;
    public int $index = 0;

    public function setImage(int $index): void
    {
        $this->index = $index;
    }
}

?>

<div class="flex gap-6">
    <div>
        <img src="{{ $images[$index] }}" alt="#" />
    </div>

    <div class="flex flex-col gap-6 w-32">
        @foreach($images as $i => $image)
            <button wire:click="setImage({{ $i }})">
                <img src="{{ $image }}" alt="#" class="w-32" />
            </button>
        @endforeach
    </div>
</div>
