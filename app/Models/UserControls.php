<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserControls extends Model
{
    //
    protected $fillable = [
        'user_id',
        'consumer',
        'enterprise',
    ];

    /**
     *  Get All Users Enterprise Controls
     */
    public function enterprise_controls()
    {
        return $this->hasMany('App\Models\UserEnterpriseControl','user_control_id','id');
    }


    /**
     * Get All Users Location Controls
     */
    public function location_controls()
    {
        return $this->hasMany('App\Models\UserLocationsControl','user_control_id','id');
    }

    /**
     * Get All Users Location Controls
     */
    public function services_controls()
    {
        return $this->hasMany('App\Models\UserServicesControl','user_control_id','id');
    }

    /**
     * Get All Users Location Controls
     */
    public function concern_controls()
    {
        return $this->hasMany('App\Models\UserConcernTypeControl','user_control_id','id');
    }
}
