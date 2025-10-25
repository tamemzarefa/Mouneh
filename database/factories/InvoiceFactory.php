<?php

namespace Database\Factories;

use App\Models\Invoice;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<Invoice> */
class InvoiceFactory extends Factory
{
    protected $model = Invoice::class;

    public function definition(): array
    {
        $total = $this->faker->numberBetween(10000, 900000); // cents
        $status = $this->faker->randomElement(['pending','processing','paid','failed']);
        $issuedAt = $this->faker->dateTimeBetween('-90 days', 'now');
        $dueDate = (clone $issuedAt)->modify('+14 days');
        return [
            'user_id' => User::factory(),
            'total_cents' => $total,
            'currency' => $this->faker->randomElement(['SYP','USD','EUR']),
            'status' => $status,
            'issued_at' => $issuedAt,
            'due_date' => $dueDate,
            'meta' => [ 'number' => strtoupper($this->faker->bothify('INV-####-####')) ],
            'created_at' => $issuedAt,
            'updated_at' => now(),
        ];
    }

    public function paid(): self
    {
        return $this->state(fn () => [ 'status' => 'paid' ]);
    }

    public function processing(): self
    {
        return $this->state(fn () => [ 'status' => 'processing' ]);
    }

    public function failed(): self
    {
        return $this->state(fn () => [ 'status' => 'failed' ]);
    }
}
