<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        'App\Events\PushNotification' => [
            'App\Listeners\SendPushNotification',
        ],
        'App\Events\ChatCreated' => [
            'App\Listeners\CreateGroupMessages',
            'App\Listeners\CreateParticipant'
        ],
        'App\Events\MessageDelivered' => [
            'App\Listeners\SendMessageStatus'
        ],
        'App\Events\UsersOnline' => [
            'App\Listeners\UpdateMessageStatus'
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
