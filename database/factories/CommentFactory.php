<?php

namespace Database\Factories;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class CommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => $this->faker->randomElement(User::pluck('id')),
            'post_id' => $this->faker->randomElement(Post::pluck('id')),
            'slug' => Str::random(44),
            'content' => $this->faker->text(333)
        ];
    }

    /**
     * Indicate that the user is suspended.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function suspended()
    {
        return $this->state(function (array $attributes) {
            $parent_id = $this->faker->randomElement(Comment::pluck('id'));
            $post_id = $this->faker->randomElement(Comment::pluck('post_id'));
            if ($post_id !== Comment::where('id', $parent_id)->first()->post_id) {
                $parent_id = null;
            }
            return [
                'parent_id' => $parent_id,
                'post_id' => $post_id,
            ];
        });
    }
}
