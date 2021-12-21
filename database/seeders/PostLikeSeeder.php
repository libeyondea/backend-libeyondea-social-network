<?php

namespace Database\Seeders;

use App\Models\PostLike;
use Illuminate\Database\Seeder;

class PostLikeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i <= 50; $i++) {
            PostLike::factory(1)->create();
        }
    }
}
