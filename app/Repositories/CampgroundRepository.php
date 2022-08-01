<?php
 declare(strict_types=1);

namespace App\Repositories;

use App\Models\Campground;
use \Illuminate\Database\Eloquent\Collection;

class CampgroundRepository{
    public function getCampgrounds() : Collection
    {
        return Campground::all();
    }

    public function getCampground($id){
        return Campground::find($id);
    }

}
