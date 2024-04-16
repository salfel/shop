<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Felix Salcher',
            'email' => 'felix.salcher@gmail.com',
            'password' => bcrypt('password'),
            'is_admin' => true,
        ]);

        User::factory(5)->create();

        Product::factory(20)->create();

        $this->call(ReviewSeeder::class);
    }
}
