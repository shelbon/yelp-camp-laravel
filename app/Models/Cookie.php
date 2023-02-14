<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Kitar\Dynamodb\Model\Model;

class Cookie extends Model
{
    use HasFactory;
    protected $table="Cookies";
}
