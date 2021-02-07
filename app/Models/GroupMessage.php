<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GroupMessage extends Model
{

    public $appends = ['last_message'];
    //
    protected $fillable = [
        'title',
        'thread_id',
        'creator_id',
        'image'
    ];

    /**
     * Get all Users connected to group messages
     *
     *
     */
    public function users()
    {
        return $this->belongsToMany('App\Models\User');
    }

    /**
     * Get all participant
     */
    public function participant()
    {
        return $this->hasMany('App\Models\Participant','group_message_id','id');
    }


    /**
     * Get User
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User', 'creator_id');
    }


    /**
     * Get Messages
     */
    public function messages()
    {
        return $this->hasMany('App\Models\Message','thread_id','thread_id');
    }


    /**
     * Get the last message
     *
     */
    public function getLastMessageAttribute()
    {
        $message = $this->messages()->orderBy('created_at','desc')->first();

        if(is_null($message) === FALSE){
            return $message->chat;
        }
        return null;
    }

    /**
     * Get Message
     */
    public function message()
    {
        return $this->hasOne('App\Models\Message','thread_id','thread_id');
    }
}
