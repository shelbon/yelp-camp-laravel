<?php

namespace Tests\Unit;

use App\Models\Campground;
use App\Models\Review;
use Kitar\Dynamodb\Model\KeyMissingException;
use Tests\TestCase;

class CampgroundRepositoryTest extends TestCase
{


    public function test_can_save_campground(): void
    {
        $campground = Campground::factory()->create();
        $campground->save();
        $savedCampground = Campground::find($campground->id);
        $this->assertInstanceOf(Campground::class, $savedCampground);
        $this->assertEquals($savedCampground->getAttributes(), $campground->getAttributes());
        $savedCampground->delete();
    }

    public function test_can_save_campground_without_id(): void
    {
        $this->expectException(KeyMissingException::class);
        $campground = new Campground();
        $campground->save();
        $campground->delete();

    }

    public function test_should_save_review(): void
    {
        $newReview = Review::factory()->create();
        $newReview->save();
        $savedReview = Review::find($newReview->id);
        $this->assertInstanceOf(Review::class, $savedReview);
        $this->assertEquals($savedReview->getAttributes(), $newReview->getAttributes());
        $savedReview->delete();
    }

}
