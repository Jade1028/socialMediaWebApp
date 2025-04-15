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
        // Get two different random users
        $user1 = User::inRandomOrder()->first();

        // Get a different user (not the same as user1)
        $user2 = User::where('id', '!=', $user1->id)
            ->inRandomOrder()
            ->first();

        // Ensure user_id1 is always the smaller ID to avoid duplicate pairs
        /**
         * example:
         * 
         * user1 = 9, user2 = 8
         * 
         * 9,8 and 8,9 are the same relationships
         * so we just keep 8,9
         * 
         */
        if ($user1->id > $user2->id) {
            $temp = $user1;
            $user1 = $user2;
            $user2 = $temp;
        }

        return [
            'user_id1' => $user1->id,
            'user_id2' => $user2->id,
            'status' => $this->faker->randomElement(['pending', 'accepted', 'rejected']),
        ];
    }
}
