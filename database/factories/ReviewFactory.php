<?php

namespace Database\Factories;

use App\Models\Campground;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Collection;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Review>
 */
class ReviewFactory extends Factory
{
    private Collection $users;
    private Collection $campgrounds;

    public function __construct($count = null, ?Collection $states = null, ?Collection $has = null, ?Collection $for = null, ?Collection $afterMaking = null, ?Collection $afterCreating = null, $connection = null)
    {
        parent::__construct($count, $states, $has, $for, $afterMaking, $afterCreating, $connection);
        $this->users = User::all();
        $this->campgrounds = Campground::all();
    }

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            "id" => fake()->uuid(),
            "body" => fake()->realText(),
            "author_id" => $this->randomAuthorId(),
            "campground_id" => $this->randomCampground_id()
        ];
    }

    private function randomAuthorId()
    {
        $index = random_int(0, $this->users->count() - 1);
        return $this->users->get($index)->id;
    }

    private function randomCampground_id()
    {
        $index = random_int(0, $this->campgrounds->count() - 1);
        return $this->campgrounds->get($index)->id;
    }
}
