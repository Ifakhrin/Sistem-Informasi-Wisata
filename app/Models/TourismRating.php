<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TourismRating extends Model
{
    protected $fillable = [
        'user_dataset_id',
        'place_id',
        'place_rating',
    ];
}