<?php
declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;

class Campground extends Model
{
    use HasFactory;

    protected $connection = 'mongodb';
    protected $attributes = [
        'title', 'image', 'price', 'description', 'location'
    ];

}
