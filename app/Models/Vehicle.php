<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    public $table = "vehicles";

    public $appends = ['last_check_up','next_check_up'];

    //
    protected $fillable = [
        'make',
        'model',
        'year',
        'variant',
        'mileage',
        'fuel',
        'plate_no',
        'engine_code',
        'chassis_code',
        'aap_in_number',
        'user_id',
        'enterprise_id'
    ];


    /**
     * Get all joborders of vehicle
     *
     */
    public function joborders()
    {
        return $this->hasMany('App\Models\Joborder','vehicle_id','id');
    }

    /**
     * Get the last check up of vehicle
     *
     */
    public function getLastCheckUpAttribute()
    {
        $joborder = $this->joborders()->where('status','completed')->orderBy('created_at','desc')->first();

        if(is_null($joborder) === FALSE){
            return $joborder->completed_at;
        }

        return null;
    }

    /**
     * Get the last check up of vehicle
     *
     */
    public function getNextCheckUpAttribute()
    {
        $joborder = $this->joborders()->where('status','completed')->orderBy('created_at','desc')->first();

        if(is_null($joborder) === FALSE){
            return $joborder->check_up;
        }
        return null;
    }

}
