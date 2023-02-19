<?php
declare(strict_types=1);

namespace App\Repositories;

use App\Models\Campground;
use App\Models\Review;
use Illuminate\Support\Collection;
use Ramsey\Uuid\Uuid;

class CampgroundRepository
{
    public function getCampgrounds(): Collection
    {
        return Campground::all();
    }

    public function create($data): void
    {
        $campground = new Campground();
        $campground->id = Uuid::uuid4()->toString();
        $campground->title = $data['name'];
        $campground->image = json_encode($data['image'],);
        $campground->price = $data['price'];
        $campground->description = $data['description'];
        $campground->author_id = $data["id"];
        $campground->save();
    }

    public function delete($campground): int
    {

        return (int)$campground->delete();
    }

    public function edit($campground): void
    {

        $campground->save();
    }

    public function search(string $search)
    {
        return Campground::filter("title", "contains", $search)->scan();
    }

    public function addReview(Campground $campground, Review $review): void
    {
        $campground->addReview($review);
        $campground->save();
        $review->save();
    }

}
