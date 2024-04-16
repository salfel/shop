<?php

use App\Models\User;
use App\Models\Product;
use Livewire\Volt\Volt;

beforeEach(function() {
    $this->user = User::factory()->create();
    $this->actingAs($this->user);
});

test('can render favourites')
    ->get('/favourites')
    ->assertStatus(200);

test('can favor product', function () {
    $product = Product::factory()->create();

    $this->get(route('products.show', [$product->id]))
        ->assertSeeVolt('products.favourite-button');

    Volt::test('products.favourite-button', ['product' => $product])
        ->call('favor');

    $this->assertDatabaseHas('favourites', [
        'product_id' => $product->id,
        'user_id' => $this->user->id
    ]);

    $this->get(route('favourites'))
        ->assertSee($product->name);
});
