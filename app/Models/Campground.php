<?php
declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Collection;
use Kitar\Dynamodb\Model\Model;


class Campground extends Model
{
    use HasFactory;

    protected $table = "Campgrounds";
    protected $primaryKey = "id";

    protected $attributes = [
        'title', 'image', 'price', 'description', 'location', "author_id",
    ];

    public function withReviewsAndRelationships(): Campground
    {

        $campground = clone $this;
        $reviews =$this->reviews() ;
        $reviews = $reviews->map(function ($review) {
            return $review->withAuthor();
        });
        $campground->reviews = $reviews;

        return $campground;
    }
    public function reviews(): Collection
    {
       return Review::index("reviewsByCampground-index")
        ->keyCondition("campground_id", '=',$this->id)
        ->query();
    }
    public function withAuthor(): Campground
    {
        $campground = clone $this;
        $author = User::filter("id", "=", $campground->author_id)
            ->scan()?->first();
        $campground->author = $author;

        return $campground;
    }

    public function addReview($review): void
    {
        $reviewIds = $this->review_ids;
        if ($reviewIds) {
            $this->review_ids = array_merge($reviewIds, [$review->id]);
        } else {
            $this->review_ids = [$review->id];
        }
    }

    public function where($field, $value): Collection
    {
        return $this->filter($field, "=", $value)
            ->scan();

    }

    public function getImage(): ?Image
    {
        if (!filter_var($this->attributes["image"], FILTER_VALIDATE_URL)) {
            return Image::createFromArray(json_decode($this->attributes["image"], true));
        }
        return null;

    }


}
