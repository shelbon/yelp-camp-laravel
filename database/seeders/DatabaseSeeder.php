<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Campground;
use App\Models\Review;
use App\Models\User;
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


        User::factory()->create([
            'username' => fake()->userName(),
            'name' => fake()->name,
            '_id' => '62f25c37b95728eb9f09ca22',
            'password' => '$2y$10$3MKIzH6OJ3ZxlYoy/H1mjea6.yIixLnNmmdH07qhQ3xoPBAcKLcwK',
            'email' => 'test@example.com',
        ]);
        Campground::factory(50)->hasReviews(5)->create();

    }
}
