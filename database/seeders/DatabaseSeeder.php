<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        $this->call([
            CategorySeeder::class,
            AdminUserSeeder::class,
        ]);

        // Create 20 products with images
        $products = Product::factory()->count(20)->create();
        foreach ($products as $product) {
            // Primary image
            ProductImage::create([
                'product_id' => $product->id,
                'url' => fake()->imageUrl(800, 600, 'food', true),
                'sort_order' => 0,
            ]);
            // 1-3 gallery images
            $galleryCount = rand(1, 3);
            for ($i = 1; $i <= $galleryCount; $i++) {
                ProductImage::create([
                    'product_id' => $product->id,
                    'url' => fake()->imageUrl(800, 600, 'food', true),
                    'sort_order' => $i,
                ]);
            }
        }
    }
}
