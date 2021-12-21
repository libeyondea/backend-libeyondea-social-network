<?php

namespace Database\Factories;

use App\Models\Post;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;

class ImageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $imageFile = new File($this->faker->image(null, 300, 300, 'nature'));
        $imageName = Str::random(66) . '.' . $imageFile->extension();
        Storage::disk('img')->put($imageName, file_get_contents($imageFile));
        return [
            'post_id' => $this->faker->randomElement(Post::pluck('id')),
            'name' => $imageName,
        ];
    }
}
