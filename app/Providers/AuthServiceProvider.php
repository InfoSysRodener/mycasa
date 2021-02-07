<?php

namespace App\Providers;

use App\Models\Booking;
use App\Policies\BookingPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
        'App\Models\Booking'    => 'App\Policies\BookingPolicy',
        'App\Models\Joborder'   => 'App\Policies\JoborderPolicy',
        'App\Models\Message'    => 'App\Policies\MessagePolicy',
        'App\Models\Vehicle'    => 'App\Policies\VehiclePolicy',
        'App\Models\Enterprise' => 'App\Policies\EnterprisePolicy' ,
        'App\Models\Ads'        => 'App\Policies\AdsPolicy'
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
