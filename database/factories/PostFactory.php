<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title'=> $this->faker->sentence(4),
            'content'=> $this->faker->paragraph(4),
            'user_id'=> User::inRandomOrder()->first()->id
        ];
    }
}
