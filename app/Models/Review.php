<?php
declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;


class Review extends Model
{
    use HasFactory;

    protected $primaryKey = '_id';

    protected $connection = 'mongodb';
    protected $attributes = [
        'body', 'author_id'
    ];
    protected $fillable = [
        'body', 'author_id'
    ];

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id', '_id');
    }

    public function campground()
    {
        return $this->belongsTo(Campground::class);
    }
}
