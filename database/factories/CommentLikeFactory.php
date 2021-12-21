<?php

namespace Database\Factories;

use App\Models\Comment;
use App\Models\CommentLike;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class CommentLikeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $userId = $this->faker->randomElement(User::pluck('id'));
        $commentId = $this->faker->randomElement(Comment::pluck('id'));

        while (CommentLike::where('user_id', $userId)->where('comment_id', $commentId)->get()->count() > 0) {
            $commentId = $this->faker->randomElement(Comment::pluck('id'));
        }

        return [
            'user_id' => $userId,
            'comment_id' => $commentId
        ];
    }
}
