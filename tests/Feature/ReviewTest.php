<?php

use App\Models\Product;
use App\Models\Review;
use App\Models\User;
use Livewire\Volt\Volt;

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->product = Product::factory()->create();

    $this->actingAs($this->user);

});

test('can view reviews', function () {
    $reviews = Review::factory(10)->create([
        'product_id' => $this->product->id,
        'user_id' => $this->user->id,
    ]);

    $component = $this->get(route('products.show', [$this->product->id]))
        ->assertStatus(200)
        ->assertSee('products.reviews');

    foreach ($reviews as $review) {
        $component
            ->assertSee($review->body)
            ->assertSee($review->user->name);
    }
});

test('can create review', function () {
    $this->get(route('products.show', [$this->product->id]))
        ->assertSeeVolt('products.reviews');

    $text = fake()->text();

    Volt::test('products.review-form', ['product' => $this->product])
        ->set('form.rating', 5)
        ->set('form.body', $text)
        ->call('send')
        ->assertDispatched('created-review');

    $this->assertDatabaseHas('reviews', [
        'product_id' => $this->product->id,
        'user_id' => $this->user->id,
        'rating' => 5,
        'body' => $text,
    ]);
});
