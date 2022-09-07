<?php

namespace Database\Factories;

use App\Models\Campground;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Campground>
 */
class CampgroundFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Campground::class;
    private array $places = [
        'Flats',
        'Village',
        'Canyon',
        'Pond',
        'Group Camp',
        'Horse Camp',
        'Ghost Town',
        'Camp',
        'Dispersed Camp',
        'Backcountry',
        'River',
        'Creek',
        'Creekside',
        'Bay',
        'Spring',
        'Bayshore',
        'Sands',
        'Mule Camp',
        'Hunting Camp',
        'Cliffs',
        'Hollow'
    ];
    private array $descriptors = [
        'Forest',
        'Ancient',
        'Petrified',
        'Roaring',
        'Cascade',
        'Tumbling',
        'Silent',
        'Redwood',
        'Bullfrog',
        'Maple',
        'Misty',
        'Elk',
        'Grizzly',
        'Ocean',
        'Sea',
        'Sky',
        'Dusty',
        'Diamond'
    ];

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    { //TODO reviews random not  own by a campground
        return [
            "title" => $this->sample($this->descriptors) . " " . $this->sample($this->places),
            "image" => "https://source.unsplash.com/collection/483251",
            "price" => floor(rand(10, 1000)),
            "description" => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Quibusdam dolores vero perferendis laudantium, consequuntur voluptatibus nulla architecto, sit soluta esse iure sed labore ipsam a cum nihil atque molestiae deserunt!',
            "location" => fake()->address,
            "author_id" => "62f25c37b95728eb9f09ca22",
        ];
    }

    private function sample(array $array)
    {
        return $array[floor(rand(0, count($array) - 1))];
    }


}
