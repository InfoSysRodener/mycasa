<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Participant extends Model
{
    //
    protected $fillable = [
        'group_message_id',
        'user_id'
    ];


    /**
     *  get all user model
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User','user_id');
    }


    /**
     * get group messages
     */
    public function  conversation()
    {
        return $this->belongsTo('App\Models\GroupMessage','group_message_id');
    }
}
