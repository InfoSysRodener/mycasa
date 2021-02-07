<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JoborderServiceSupplies extends Model
{
    //
    protected $fillable = [
        'joborder_id',
        'name',
        'qty',
        'cost',
        'type'
    ];



}
