<?php

namespace App\Services;

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
}
