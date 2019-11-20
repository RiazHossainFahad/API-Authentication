<?php

namespace App;

use App\Review;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public function review()
    {
        return $this->hasMany(Review::class);
    }
}