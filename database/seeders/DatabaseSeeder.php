<?php

namespace Database\Seeders;

use Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();

        \App\Models\User::create(
           [
               'name' => 'test',
               'email' => 'test@test.com',
               'email_verified_at' => now(),
               'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
               'remember_token' => Str::random(10),
           ]
        );
//         \App\Models\User::factory(1)->create();
//         \App\Models\Post::factory(1)->create();
//         \App\Models\Like::factory(1)->create();
    }
}
