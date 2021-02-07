<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Services extends Model
{
    //
    protected $fillable = [
        'name',
        'size',
        'title',
        'price',
        'category',
        'description',
    ];
}
