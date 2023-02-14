<?php
declare(strict_types=1);

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Kitar\Dynamodb\Model\Model;

class Review extends Model
{
    use HasFactory;

    protected $primaryKey = "id";
    protected $table = "Reviews";
    protected $attributes = [
        'id', 'body', 'author_id', 'campground_id', 'created_at', 'updated_at'
    ];
    protected $fillable = [
        'id', 'body', 'author_id', 'campground_id'
    ];

    public function withAuthor(): Review
    {
        $review = clone $this;
        $review->author = User::filter("id", "=", $this->author_id)
            ->scan()?->first();
        return $review;
    }

}
