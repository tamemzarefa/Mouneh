<?php

namespace Database\Factories;

use App\Models\Conversation;
use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<Conversation> */
class ConversationFactory extends Factory
{
    protected $model = Conversation::class;

    public function definition(): array
    {
        return [
            'buyer_id' => User::factory(),
            'seller_id' => User::factory(),
            'order_id' => $this->faker->boolean(50) ? Order::factory() : null,
        ];
    }
}
