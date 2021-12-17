<?php

namespace Database\Factories;

use App\Models\Follower;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class FollowerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $userId = $this->faker->randomElement(User::pluck('id'));
        $followerId = $this->faker->randomElement(User::pluck('id'));

        while ($userId === $followerId) {
            $followerId = $this->faker->randomElement(User::pluck('id'));
        }

        while (Follower::where('user_id', $userId)->where('follower_id', $followerId)->get()->count() > 0) {
            $followerId = $this->faker->randomElement(User::pluck('id'));
        }

        return [
            'user_id' => $userId,
            'follower_id' => $followerId
        ];
    }
}
