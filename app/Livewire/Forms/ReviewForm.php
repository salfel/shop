<?php

namespace App\Livewire\Forms;

use App\Models\Review;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Validate;
use Livewire\Form;

class ReviewForm extends Form
{
    #[Validate(['required', 'int', 'between:1,5'])]
    public int $rating = 1;

    #[Validate(['required', 'string'])]
    public string $body = '';

    public function createReview(int $productId): Review
    {
        return Review::create([
            'user_id' => Auth::id(),
            'product_id' => $productId,
            'rating' => $this->rating,
            'body' => $this->body,
        ]);
    }
}
