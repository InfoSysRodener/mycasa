<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    public $table = "branches";
    //
    protected $fillable = [
        'code',
        'name'
    ];

    public function information() {
        return $this->belongsTo('App\Models\UserInformation', 'branch_id');
    }

}
