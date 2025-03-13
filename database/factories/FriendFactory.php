<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class FriendFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id1'=> User::inRandomOrder()->first()->id,
            'user_id2'=> User::inRandomOrder()->first()->id,
            'status'=> $this->faker->randomElement(['pending', 'accepted', 'rejected']),
        ];
    }
}
