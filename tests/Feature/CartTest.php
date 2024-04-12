<?php

use App\Models\Product;
use App\Models\User;
use Livewire\Volt\Volt;

test('product can be added to cart', function () {
    $product = Product::factory()->create();
    $user = User::factory()->create();

    if ($user->cart == null) {
        throw new Exception('User cart was not created');
    }

    $this->actingAs($user);

    Volt::test('products.add-cart', ['id' => $product->id])
        ->call('addToCart');

    $this->assertDatabaseHas('cart_products', [
        'product_id' => $product->id,
        'cart_id' => $user->cart->id,
    ]);
});
