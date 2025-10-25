<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<Product> */
class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        $title = $this->faker->unique()->words(3, true);
        return [
            'seller_id' => User::factory(),
            'category_id' => Category::factory(),
            'title_ar' => $title,
            'title_en' => $this->faker->optional()->sentence(3),
            'description_ar' => $this->faker->optional()->paragraph(),
            'description_en' => $this->faker->optional()->paragraph(),
            'price_cents' => $this->faker->numberBetween(5000, 500000),
            'currency' => 'SYP',
            'stock' => $this->faker->numberBetween(0, 200),
            'is_active' => $this->faker->boolean(85),
            'avg_rating' => $this->faker->randomFloat(2, 0, 5),
        ];
    }
}
