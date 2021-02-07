<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserConcernTypeControl extends Model
{
    //
    protected $fillable = [
        'user_control_id',
        'concern_type'
    ];
}
