<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RewardRate extends Model
{
    //
    protected $fillable = [
        'reward_convertion_rate',
        'over_total',
        'value'
    ];
}
