<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class MessageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'sender_id'=> User::inRandomOrder()->first()->id,
            'receiver_id'=>User::inRandomOrder()->first()->id,
            'content'=> $this->faker->paragraph(4),
        ];
    }
}
