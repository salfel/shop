<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * @template TModel of Model
 *
 * @extends Factory<TModel>
 */
class ProductFactory extends Factory
{
    protected $model = Product::class;

    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $images = [];
        for ($i = 0; $i < 3; $i++) {
            $images[] = $this->faker->imageUrl();
        }

        return [
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'name' => 'Product '.$this->faker->randomNumber(3),
            'description' => $this->faker->text(),
            'price' => $this->faker->randomFloat(min: 10, max: 100),
            'images' => $images,
            'quantity' => $this->faker->randomNumber(2, true),
        ];
    }
}
