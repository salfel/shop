<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'images',
        'quantity',
    ];

    protected $casts = [
        'images' => 'array',
    ];

    protected static function booted(): void
    {
        static::created(function (Product $product) {
            $stripe = new \Stripe\StripeClient(config('cashier.secret'));

            $stripeProduct = $stripe->products->create([
                'name' => $product->name,
                'default_price_data' => [
                    'currency' => 'eur',
                    'unit_amount' => $product->price * 100,
                ],
                'images' => $product->images,
                'expand' => ['default_price'],
            ]);

            $product->update([
                'stripe_id' => $stripeProduct->default_price->id,
            ]);
        });

        static::deleted(function (Product $product) {
            $stripe = new \Stripe\StripeClient(config('cashier.secret'));

            $stripe->products->delete($product->stripe_id);
        });
    }
}
