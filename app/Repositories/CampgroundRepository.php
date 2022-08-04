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
    public function create($data){
        $campground=new Campground();
        $campground->title=$data['name'];
        $campground->image=$data['image'];
        $campground->price=$data['price'];
        $campground->description=$data['description'];
        $campground->save();
    }
    public function delete($id): int {
        return Campground::destroy($id);
    }

    public function edit(array $data){
        $campground=Campground::find($data['id']);
        $campground->title=$data['title'];
        $campground->image=$data['image'];
        $campground->price=$data['price'];
        $campground->description=$data['description'];
        $campground->save();
    }

}
