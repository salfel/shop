<?php

use App\Http\Controllers\WebhookController;
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

    $component = Volt::test('products.add-cart', ['id' => $product->id])
        ->call('addToCart');

    $this->assertDatabaseHas('cart_product', [
        'product_id' => $product->id,
        'cart_id' => $this->user->cart->id,
        'amount' => 1,
    ]);

    $component->call('addToCart');

    $this->assertDatabaseHas('cart_product', [
        'product_id' => $product->id,
        'cart_id' => $this->user->cart->id,
        'amount' => 2,
    ]);
});

// @phpstan-ignore-next-line
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
    ])->firstOrFail();

    Volt::test('cart.product-table', ['cart' => $this->user->cart])
        ->assertSeeVolt('cart.product-row')
        ->call('removeProduct', $cartProduct->id);

    $this->assertDatabaseMissing('cart_product', [
        'product_id' => $product->id,
        'cart_id' => $this->user->cart->id,
    ]);
});

test('checkout works as expected', function () {
    $payload = ['data' => ['object' => ['customer_details' => ['email' => $this->user->email]]]];

    $products = Product::factory(3)->create();

    foreach ($products as $product) {
        $this->user->cart->products()->attach($product->id, ['amount' => 1]);
    }

    $webhookController = new WebhookController;

    $webhookController->handleCheckoutSessionCompleted($payload);

    expect($this->user->cart->products_count)->toBe(0);

    foreach ($products as $product) {
        $quantity = $product->quantity;
        $product->refresh();

        expect($product->quantity)->toBe($quantity - 1);
    }
});
