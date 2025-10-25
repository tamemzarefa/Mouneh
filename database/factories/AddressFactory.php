<?php

namespace Database\Factories;

use App\Models\Address;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<Address> */
class AddressFactory extends Factory
{
    protected $model = Address::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'label' => $this->faker->optional()->word(),
            'recipient_name' => $this->faker->name(),
            'phone' => $this->faker->phoneNumber(),
            'line1' => $this->faker->streetAddress(),
            'line2' => $this->faker->optional()->secondaryAddress(),
            'city' => $this->faker->city(),
            'region' => $this->faker->state(),
            'postal_code' => $this->faker->postcode(),
            'country_code' => 'SY',
            'is_default' => $this->faker->boolean(20),
        ];
    }
}
