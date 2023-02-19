<?php

namespace Database\Factories;

use App\Models\Campground;
use App\Models\Image;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Collection;

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
    private Collection $users;

    public function __construct($count = null, ?Collection $states = null, ?Collection $has = null, ?Collection $for = null, ?Collection $afterMaking = null, ?Collection $afterCreating = null, $connection = null, ?Collection $recycle = null)
    {
        parent::__construct($count, $states, $has, $for, $afterMaking, $afterCreating, $connection, $recycle);
        $this->users = User::all();
    }

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    { //TODO reviews random not  own by a campground
        $authorId=$this->randomAuthorId();
        return [
            "id" => $this->faker->uuid(),
            "title" => $this->sample($this->descriptors) . " " . $this->sample($this->places),
            "image" => json_encode(new Image(env("AWS_S3_ENDPOINT")."/".env("AWS_S3_ASSETS_KEY")."image-not-found.png", env("AWS_BUCKET"),
                env("AWS_S3_ASSETS_KEY"),
                "",
                "image-not-found.png")),
            "price" => floor(rand(10, 1000)),
            "description" => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Quibusdam dolores vero perferendis laudantium, consequuntur voluptatibus nulla architecto, sit soluta esse iure sed labore ipsam a cum nihil atque molestiae deserunt!',
            "location" => fake()->address,
            "author_id" =>$authorId,
        ];
    }

    private function sample(array $array)
    {
        return $array[floor(rand(0, count($array) - 1))];
    }

    private function randomAuthorId()
    {
        $index = random_int(0, $this->users->count() - 1);
        return $this->users->get($index)->id;
    }


}
