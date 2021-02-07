<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserInformation extends Model
{
    public $table = "user_informations";

    //
    protected $fillable = [
        'fullname',
        'address',
        'gender',
        'birthdate',
        'user_id',
        'enterprise_id',
        'branch_id',
        'points',
        'profile'
    ];

    /**
     * Get Users Information
     *
     * @var relationship
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }

    /**
     * Get Users Branch
     *
     * @var relationship
     */
    public function branch(){
        return $this->hasOne('App\Models\Branch','id');
    }

    /**
     * Get Users Enterprise
     *
     * @var relationship
     */
    public function enterprise()
    {
        return $this->hasOne('App\Models\Enterprise','id' , 'enterprise_id');
    }

    /**
     * Get All joborders of Enterprise User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function enterprise_joborders()
    {
        return $this->hasMany('App\Models\Joborder','enterprise_id','enterprise_id');
    }
}
