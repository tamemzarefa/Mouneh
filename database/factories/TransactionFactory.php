<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<Transaction> */
class TransactionFactory extends Factory
{
    protected $model = Transaction::class;

    public function definition(): array
    {
        $amount = $this->faker->numberBetween(5000, 500000); // cents
        $status = $this->faker->randomElement(['pending','processing','paid','failed']);
        return [
            'user_id' => User::factory(),
            'order_id' => Order::factory(),
            'type' => $this->faker->randomElement(['charge','payout','refund']),
            'amount_cents' => $amount,
            'currency' => $this->faker->randomElement(['SYP','USD','EUR']),
            'status' => $status,
            'meta' => [
                'gateway' => $this->faker->randomElement(['stripe','paypal','cod']),
                'reference' => strtoupper($this->faker->bothify('TX-####-????')),
            ],
            'created_at' => $this->faker->dateTimeBetween('-60 days', 'now'),
            'updated_at' => now(),
        ];
    }

    public function paid(): self
    {
        return $this->state(fn () => [ 'status' => 'paid' ]);
    }

    public function failed(): self
    {
        return $this->state(fn () => [ 'status' => 'failed' ]);
    }

    public function pending(): self
    {
        return $this->state(fn () => [ 'status' => 'pending' ]);
    }
}
