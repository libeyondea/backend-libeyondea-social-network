<?php

namespace Database\Seeders;

use App\Models\PostLike;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            UserSeeder::class,
            PostSeeder::class,
            ImageSeeder::class,
            CommentSeeder::class,
            FollowerSeeder::class,
            PostLikeSeeder::class,
            CommentLikeSeeder::class,
        ]);
    }
}
