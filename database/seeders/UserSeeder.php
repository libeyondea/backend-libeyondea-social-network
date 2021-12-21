<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'first_name' => 'Thuc',
            'last_name' => 'Nguyen',
            'avatar' => 'libeyondea.png',
            'user_name' => 'libeyondea',
            'email' => 'libeyondea@gmail.com',
            'password' => bcrypt('libeyondea')
        ]);
        User::factory(10)->create();
    }
}
