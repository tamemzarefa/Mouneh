<?php

namespace Database\Factories;

use App\Models\SellerProfile;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<SellerProfile> */
class SellerProfileFactory extends Factory
{
    protected $model = SellerProfile::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'display_name' => $this->faker->company(),
            'bio' => $this->faker->optional()->paragraph(),
            'city' => $this->faker->optional()->city(),
            'region' => $this->faker->optional()->state(),
            'approved' => $this->faker->boolean(70),
        ];
    }
}
