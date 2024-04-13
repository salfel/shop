<?php

use App\Models\CartProduct;
use App\Models\Product;
use App\Models\User;
use Livewire\Volt\Volt;

beforeEach(function () {
    $this->user = User::factory()->create();

    if ($this->user->cart == null) {
        throw new Exception('User cart was not created');
    }

    $this->actingAs($this->user);
});

test('cart screen can be rendered', function () {
    $product = Product::factory()->create();

    $this->user->cart->products()->attach($product->id, ['amount' => 1]);

    $this->get(route('cart'))
        ->assertStatus(200)
        ->assertSee($product->name)
        ->assertSeeVolt('cart.product-table');
});

test('product can be added to cart', function () {
    $product = Product::factory()->create();

    Volt::test('products.add-cart', ['id' => $product->id])
        ->call('addToCart');

    $this->assertDatabaseHas('cart_product', [
        'product_id' => $product->id,
        'cart_id' => $this->user->cart->id,
    ]);
});

test('User can increase amount of cart', function (int $amount) {
    $product = Product::factory()->create();

    $this->user->cart->products()->attach($product->id, ['amount' => 1]);

    $component = Volt::test('cart.product-row', ['product' => $this->user->cart->products->first()]);

    $component->call('updateAmount', $amount)
        ->assertDispatched('updated-cart');

    if ($amount < 1) {
        $this->assertDatabaseHas('cart_product', [
            'product_id' => $product->id,
            'cart_id' => $this->user->cart->id,
            'amount' => 1,
        ]);

        return;
    }

    $component->assertViewHas('amount', $amount);

    $this->assertDatabaseHas('cart_product', [
        'product_id' => $product->id,
        'cart_id' => $this->user->cart->id,
        'amount' => $amount,
    ]);
})->with([2, 5, 8, 0]);

test('user can delete product from cart', function () {
    $product = Product::factory()->create();

    $this->user->cart->products()->attach($product->id, ['amount' => 1]);

    $cartProduct = CartProduct::where([
        'product_id' => $product->id,
        'cart_id' => $this->user->cart->id,
    ])->first();

    Volt::test('cart.product-table', ['cart' => $this->user->cart])
        ->assertSeeVolt('cart.product-row')
        ->call('removeProduct', $cartProduct->id);

    $this->assertDatabaseMissing('cart_product', [
        'product_id' => $product->id,
        'cart_id' => $this->user->cart->id,
    ]);
});
