<?php

use App\Models\Product;
use App\Models\Review;
use Livewire\Volt\Component;

use App\Helpers\Format;

new class extends Component {
    public array $reviews;
    public Product $product;

    public function removeReview(int $id): void
    {
        Review::find($id)->delete();

        $this->reviews = array_filter($this->reviews, fn ($review) => $review->id !== $id);
    }
};

?>


<div class="space-y-6">
    @foreach($reviews as $review)
        <x-card :key="$review->id">
            <div class="space-y-3">
                <div class="flex items-center gap-3">
                    <x-avatar label="{{ Format::avatarLabel($review->user->name) }}"/>

                    <p>{{ $review->user->name }}</p>

                    @auth
                        @if(auth()->user()->id === $review->user_id)
                            <button wire:click="removeReview({{ $review->id }})" class="ml-auto">
                                <x-icon name="trash" class="size-5 text-red-500"/>
                            </button>
                        @endif
                    @endauth
                </div>

                <div class="flex gap-1">
                    @for($i = 0; $i < 5; $i++)
                        <x-icon name="star" class="size-5 text-yellow-500" :solid="$i < $review->rating"/>
                    @endfor
                </div>

                <p>{{ $review->body }}</p>
            </div>
        </x-card>
    @endforeach
</div>
