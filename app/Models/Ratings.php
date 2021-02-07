<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ratings extends Model
{
    //
    protected $fillable = [
        'user_id',
        'ratings',
        'valueformoney',
        'politeness',
        'cleanliness',
        'technical',
        'joborder_id'
    ];
}
