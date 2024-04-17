<?php

use App\Models\Product;
use App\Models\Review;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\On;
use Livewire\Volt\Component;

use App\Helpers\Format;

new class extends Component {
    public array $reviews;
    public Product $product;

    public string $links;

    public function mount(LengthAwarePaginator $paginator): void
    {
        $this->reviews = $paginator->items();

        $this->links = $paginator->links()->toHtml();
    }

    public function loadReviews(): void
    {
        $paginator = $this->product->reviews()->with('user')->orderByDesc('created_at')
            ->paginate(12, pageName: 'reviews_page', page: 1);

        $this->reviews = $paginator->items();
        $this->links = $paginator->links()->toHtml();
    }
};

?>


<div class="pt-8 space-y-6">
    <h3 class="text-xl font-medium">Reviews</h3>

    @auth
        <livewire:products.review-form :product="$product" @created-review="loadReviews"/>
    @endauth

    <div class="space-y-6">
        @foreach($reviews as $review)
            <x-card wire:key="{{ $review->id }}">
                <div class="space-y-3">
                    <div class="flex items-center gap-3">
                        <x-avatar label="{{ Format::avatarLabel($review->user->name) }}"/>

                        <p>{{ $review->user->name }}</p>
                    </div>

                    <div class="flex gap-1">
                        @for($i = 0; $i < 5; $i++)
                            <x-icon name="star" class="size-5 text-yellow-500" :solid="$i < $review->rating"/>
                        @endfor
                    </div>

                    <p>{{ $review->body }}</p>
                </div>
            </x-card:>
        @endforeach
    </div>

    {!! $links !!}
</div>
