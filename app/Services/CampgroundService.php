<?php

namespace App\Services;

use App\Models\Campground;
use App\Models\Image;
use App\Models\Review;
use App\Repositories\CampgroundRepository;
use Aws\Exception\MultipartUploadException;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
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
    public function __construct(CampgroundRepository $campgroundRepository, CampgroundImageService $campgroundImageService)
    {
        $this->campgroundRepository = $campgroundRepository;
        $this->campgroundImageService = $campgroundImageService;
    }

    public function getCampgrounds(): Collection
    {
        return $this->campgroundRepository->getCampgrounds();
    }

    public function create(array $data): void
    {
        try {
            $uploadResult = $this->campgroundImageService->upload($data["image"], env("AWS_BUCKET"), env("AWS_S3_KEY"));
            if ($uploadResult["@metadata"]["statusCode"] == '200') {
                $data["image"] = new Image($uploadResult["@metadata"]["effectiveUri"], env("AWS_BUCKET"),
                    env("AWS_S3_KEY"),
                    auth::user()?->getId(),
                    $data["image"]->getClientOriginalName());
                $this->campgroundRepository->create($data);
            }
        } catch (MultipartUploadException $e) {
            throw  ValidationException::withMessages([
                "image" => trans("validation.uploaded", ["attribute" => "image"])
            ]);
        }

    }

    public function edit(array $data, Campground $campground)
    {
        $campground->title = $data['title'];
        $campground->price = $data['price'];
        $campground->description = $data['description'];
        if (isset($data['image'])) {
            $uploadResult = $this->campgroundImageService->delete($campground->getImage());
            $statusCode = (string)$uploadResult["@metadata"]["statusCode"];
            if (str_starts_with($statusCode, "2")) {
                $uploadResult = $this->campgroundImageService->upload($data["image"], env("AWS_BUCKET"), env("AWS_S3_KEY"));
                if ($uploadResult["@metadata"]["statusCode"] == '200') {
                    $campground->image = json_encode(new Image($uploadResult["@metadata"]["effectiveUri"], env("AWS_BUCKET"),
                        env("AWS_S3_KEY"),
                        auth::user()->getId(),
                        $data["image"]->getClientOriginalName()));
                }
            }
        }
        $this->campgroundRepository->edit($campground);
    }

    public function delete(Campground $campground): int
    {

        return $this->campgroundRepository->delete($campground);
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
