<?php


namespace App\Repositories;

use App\Models\Campground;


class CampgroundRepository{
    /**
     * @return Collection
     */
    public function getCampgrounds()
    {
        return Campground::all();
    }

}
