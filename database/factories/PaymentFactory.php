<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\Payment;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<Payment> */
class PaymentFactory extends Factory
{
    protected $model = Payment::class;

    public function definition(): array
    {
        $amount = $this->faker->numberBetween(10000, 600000);
        $status = $this->faker->randomElement(['pending','paid','failed','refunded']);
        return [
            'order_id' => Order::factory(),
            'provider' => $this->faker->randomElement(['manual','stripe','paypal']),
            'status' => $status,
            'reference' => $this->faker->unique()->bothify('PM-####-????'),
            'amount_cents' => $amount,
            'currency' => 'SYP',
            'paid_at' => in_array($status, ['paid','refunded']) ? $this->faker->dateTimeBetween('-60 days','now') : null,
        ];
    }
}
