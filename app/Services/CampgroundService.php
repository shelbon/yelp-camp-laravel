<?php

namespace App\Services;

use App\Models\Campground;
use App\Repositories\CampgroundRepository;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

class CampgroundService
{
    /**
     * @var CampgroundRepository
     */
    private CampgroundRepository $campgroundRepository;
    /**
     * @param CampgroundRepository $campgroundRepository
     */
    public function __construct(CampgroundRepository $campgroundRepository){
        $this->campgroundRepository=$campgroundRepository;
    }
    public  function  getCamprounds(){
        return $this->campgroundRepository->getCampgrounds();
    }

    public function getCampgrounds($id){
        if($id==null || $id<0){
            throw new BadRequestException();
        }
        return$this->campgroundRepository->getCampground($id);
    }

    public function create(array $data): void {
        $this->campgroundRepository->create($data);
    }

    public function delete(Campground $campground): int{

        return $this->campgroundRepository->delete($campground);
    }

    public function edit(Array $data, Campground $campground){
        $campground->title=$data['title'];
        $campground->image=$data['image'];
        $campground->price=$data['price'];
        $campground->description=$data['description'];
        $this->campgroundRepository->edit($campground);
    }

    public function search(string $search){
           return $this->campgroundRepository->search($search);
    }
}
