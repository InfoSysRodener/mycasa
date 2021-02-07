<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Devices extends Model
{
    //
    protected $fillable = [
        'device_token',
        'platform',
        'arn',
        'subscription_arn',
        'user_id'
    ];
}
