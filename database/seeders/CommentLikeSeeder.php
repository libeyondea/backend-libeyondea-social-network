<?php

namespace Database\Seeders;

use App\Models\CommentLike;
use Illuminate\Database\Seeder;

class CommentLikeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i <= 50; $i++) {
            CommentLike::factory(1)->create();
        }
    }
}
