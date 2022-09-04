<?php
declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Log;
use Jenssegers\Mongodb\Eloquent\Model;
use App\Models\Relations\OwnsMany;
use Jenssegers\Mongodb\Relations\BelongsToMany;

class Campground extends Model
{
    use HasFactory;

    protected $connection = 'mongodb';
    protected $attributes = [
        'title', 'image', 'price', 'description', 'location', "author_id",
    ];


    public function author()
    {
        return $this->belongsTo(User::class, "author_id", '_id')->withDefault();
    }

    public function reviews()
    {

        return $this->hasMany(Review::class);
    }


}
