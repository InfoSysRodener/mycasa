<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    public $table = "bookings";

    //
    protected $fillable = [
        'user_id',
        'vehicle_id',
        'address',
        'concern',
        'concern_type',
        'date',
        'time',
        'status',
        'enterprise_id',
        'booked_by',
        'service_category',
        'location',
        'city'
    ];

    public function user() {
        return $this->belongsTo('App\Models\User');
    }

    public function enterprise() {
        return $this->belongsTo('App\Models\Enterprise', 'enterprise_id');
    }

    public function vehicle() {
        return $this->belongsTo('App\Models\Vehicle', 'vehicle_id');
    }

    public function joborder(){
        return $this->belongsTo('App\Models\Joborder','booking_id');
    }
}

