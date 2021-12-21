<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\PostLike;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostLikeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $userId = $this->faker->randomElement(User::pluck('id'));
        $postId = $this->faker->randomElement(Post::pluck('id'));

        while (PostLike::where('user_id', $userId)->where('post_id', $postId)->get()->count() > 0) {
            $postId = $this->faker->randomElement(Post::pluck('id'));
        }

        return [
            'user_id' => $userId,
            'post_id' => $postId
        ];
    }
}
