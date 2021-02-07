<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Joborder extends Model
{
    public $table = "joborders";


    public $appends = ['joborder_id'];

    protected $hidden = ['pivot'];


    protected $fillable = [
        'code',
        'requested_at',
        'completed_at',
        'concern',
        'assessment',
        'solution',
        'discount',
        'total',
        'issued_by',
        'user_id',
        'vehicle_id',
        'branch_id',
        'status',
        'check_up',
        'recommendations',
        'mileage',
        'booking_id',
        'image',
        'concern_type',
        'schedule',
        'location',
        'feedback',
        'client_signature',
        'technician_signature',
        'enterprise_id',
        'city',
        'service_category'
    ];


    /**
     * Get all Users connected to specific joborders
     *
     * @var relationship
     */
    public function users()
    {
        return $this->belongsToMany('App\Models\User');
    }

    /**
     * Alias Users to Technician
     * @return [type] [description]
     */
    public function technicians()
    {
        return $this->users();
    }

    /**
     * Get joborder service and supplies
     */
    public function items()
    {
        return $this->hasMany('App\Models\JoborderServiceSupplies');
    }

    /**
     * Get vehicle model
     */
    public function vehicle()
    {
        return $this->belongsTo('App\Models\Vehicle', 'vehicle_id');
    }

    /**
     * Get user model
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }

    /**
     * Get enterprise model
     */
    public function enterprise()
    {
        return $this->belongsTo('App\Models\Enterprise','enterprise_id');
    }


    /**
     * Get Booking model
     */
    public function booking()
    {
        return $this->belongsTo('App\Models\Booking','booking_id');
    }


    /**
     * Get rating model
     *
     */
    public function ratings()
    {
        return $this->hasOne('App\Models\Ratings','joborder_id');
    }

    public function getJoborderIdAttribute()
    {

        //parse date
        $date = date('y-md',strtotime($this->requested_at));

        $enterprise = null;

        if(is_null($this->enterprise) === TRUE ){
            $enterprise = "JO";
        }else{
            $enterprise = $this->enterprise->prefix;
        }

        return  $enterprise.'-'.$date.'-'.$this->code;
    }
}