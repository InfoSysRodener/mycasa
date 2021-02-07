<?php

namespace App\Models;

use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    public $table = "users";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'mobile_number' ,
        'email',
        'password',
        'user_type',
        'fb_id',
        'password_reset'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'mobile_number_verified_at' => 'datetime'
    ];

    /**
     * Get Users Information
     *
     */
    public function information()
    {
        return $this->hasOne('App\Models\UserInformation', 'user_id');
    }

    /**
     * Get all joborders of Technician User
     *
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function joborders()
    {
        return $this->belongsToMany('App\Models\Joborder');
    }

    /**
     * Get all joborders of Consumer User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     *
     */
    public function user_joborders(){
        return $this->hasMany('App\Models\Joborder');
    }


    /**
     * Get all Bookings of Consumer User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     *
     */
    public function bookings(){
        return $this->hasMany('App\Models\Booking','user_id','id');
    }

    /**
     * Get Users Wallet
     *
     */
    public function wallet(){
        return $this->hasOne('App\Models\Wallets','user_id');
    }


    /**
     *  Get All Users Devices
     */
    public function devices()
    {
        return $this->hasMany('App\Models\Devices','user_id','id');
    }


    /**
     * Get User Controls
     */
    public function controls()
    {
        return $this->hasOne('App\Models\UserControls','user_id');
    }


    /**
     * Get User Vehicle
     */
    public function vehicles()
    {
        return $this->hasMany('App\Models\Vehicle','user_id','id');
    }
}
