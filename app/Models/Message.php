<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{

//    public $appends = ['last_message'];

    //
    protected $fillable = [
        'thread_id',
        'chat',
        'image',
        'is_read',
        'booking_id',
        'joborder_id',
        'user_id',
    ];


    /**
     * Get the user associated with this messages chat.
     *
     * @return model
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }

    /**
     * Get Booking associated in chat
     *
     */
    public function booking()
    {
        return $this->belongsTo('App\Models\Booking','booking_id');
    }

    /**
     *  Get Many booking associated in thread
     *
     */
    public function bookings()
    {
        return $this->hasMany('App\Models\Booking','user_id','user_id');
    }

    /**
     * Get joborder associated in chat
     *
     */
    public function joborder()
    {
        return $this->belongsTo('App\Models\Joborder','joborder_id');
    }


    /**
     * Get many joborder associated in thread
     *
     */
    public function joborders()
    {
       return  $this->hasMany('App\Models\Joborder','user_id','user_id');
    }


//    public function getImagePathAttribute(){
//
//    }
}
