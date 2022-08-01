<?php

namespace App\Http\Controllers;

use App\Services\CampgroundService;

class CampgroundController extends Controller
{
    private CampgroundService $campgroundService;

    public function __construct(CampgroundService $campgroundService){
        $this->campgroundService=$campgroundService;
    }

    public function  home(){

        return view('campgrounds.home',['campgrounds'=>
            $this->campgroundService->getCamprounds()]);
    }
    public  function campground($id){
        return view('campgrounds.detail',['campground'=>$this->campgroundService->getCampgrounds($id)]);
    }
}
