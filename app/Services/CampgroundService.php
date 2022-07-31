<?php

namespace App\Services;

use App\Repositories\CampgroundRepository;

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
}
