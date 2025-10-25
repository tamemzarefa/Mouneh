<?php

namespace Database\Factories;

use App\Models\Address;
use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<Order> */
class OrderFactory extends Factory
{
    protected $model = Order::class;

    public function definition(): array
    {
        $subtotal = $this->faker->numberBetween(10000, 500000);
        $shipping = $this->faker->randomElement([0, 1000, 2000, 5000]);
        $discount = $this->faker->randomElement([0, 500, 1000, 2000]);
        $total = max(0, $subtotal + $shipping - $discount);
        return [
            'buyer_id' => User::factory(),
            'seller_id' => User::factory(),
            'address_id' => Address::factory(),
            'status' => $this->faker->randomElement(['pending','confirmed','shipped','delivered','cancelled']),
            'subtotal_cents' => $subtotal,
            'shipping_cents' => $shipping,
            'discount_cents' => $discount,
            'total_cents' => $total,
            'currency' => 'SYP',
            'created_at' => $this->faker->dateTimeBetween('-60 days', 'now'),
            'updated_at' => now(),
        ];
    }
}
