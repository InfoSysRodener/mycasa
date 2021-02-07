<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Wallets extends Model
{
    //
    protected $fillable = [
        'reward_points',
        'lifetime_points',
        'user_id'
    ];
}
