<?php

namespace App\Services;

use App\Models\Campground;
use App\Models\Review;
use App\Repositories\CampgroundRepository;
use Illuminate\Support\Collection;
use Ramsey\Uuid\Uuid;

class CampgroundService
{
    /**
     * @var CampgroundRepository
     */
    private CampgroundRepository $campgroundRepository;

    /**
     * @param CampgroundRepository $campgroundRepository
     */
    public function __construct(CampgroundRepository $campgroundRepository)
    {
        $this->campgroundRepository = $campgroundRepository;
    }

    public function getCampgrounds(): Collection
    {
        return $this->campgroundRepository->getCampgrounds();
    }

    public function create(array $data): void
    {
        $this->campgroundRepository->create($data);
    }

    public function delete(Campground $campground): int
    {

        return $this->campgroundRepository->delete($campground);
    }

    public function edit(array $data, Campground $campground)
    {
        $campground->title = $data['title'];
        $campground->image = $data['image'];
        $campground->price = $data['price'];
        $campground->description = $data['description'];
        $this->campgroundRepository->edit($campground);
    }

    public function search(string $search)
    {
        return $this->campgroundRepository->search($search);
    }

    public function addReview(Campground $campground, $reviewData)
    {
        $review = new Review([
            'id' => Uuid::uuid4()->toString(),
            'body' => $reviewData['comment'],
            'campground_id' => $reviewData["campground_id"],
            'author_id' => $reviewData['author_id']
        ]);
        $this->campgroundRepository->addReview($campground, $review);
    }
}
