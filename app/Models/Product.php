<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property CartProduct $pivot
 */
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
            $stripe = new \Stripe\StripeClient(['api_key' => config('cashier.secret')]);

            $price = $stripe->products->create([
                'name' => $product->name,
                'default_price_data' => [
                    'currency' => 'eur',
                    'unit_amount' => $product->price * 100,
                ],
                'images' => $product->images,
                'expand' => ['default_price'],
            ])->default_price;

            if (gettype($price) != 'object' || get_class($price) !== \Stripe\Price::class) {
                return;
            }

            $product->update([
                'stripe_id' => $price->id,
            ]);
        });

        static::deleted(function (Product $product) {
            $stripe = new \Stripe\StripeClient(['api_key' => config('cashier.secret')]);

            if ($product->stripe_id == null) {
                return;
            }

            $stripe->products->delete($product->stripe_id);
        });
    }
}
