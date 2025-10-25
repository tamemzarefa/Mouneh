<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<OrderItem> */
class OrderItemFactory extends Factory
{
    protected $model = OrderItem::class;

    public function definition(): array
    {
        $unit = $this->faker->numberBetween(1000, 100000);
        $qty = $this->faker->numberBetween(1, 5);
        return [
            'order_id' => Order::factory(),
            'product_id' => Product::factory(),
            'quantity' => $qty,
            'unit_price_cents' => $unit,
            'created_at' => $this->faker->dateTimeBetween('-60 days', 'now'),
            'updated_at' => now(),
        ];
    }
}
