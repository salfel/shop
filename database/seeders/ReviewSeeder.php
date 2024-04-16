<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Review;
use App\Models\User;
use Illuminate\Database\Seeder;

class ReviewSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::all();
        foreach (Product::all() as $product) {
            Review::factory(20)->create([
                'product_id' => $product->id,
                'user_id' => fn () => $users->random()->id,
            ]);
        }
    }
}
