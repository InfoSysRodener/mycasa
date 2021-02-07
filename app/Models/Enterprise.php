<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Enterprise extends Model
{
    //
    protected $fillable = [
        'name',
        'prefix',
        'contact_person',
    ];


    /**
     *  Get all vehicle
     */
    public function vehicles()
    {
      return $this->hasMany('App\Models\Vehicle','enterprise_id','id');
    }

}
