<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use App\Models\User;

class ChatMessages implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;


    /**
     * Message details
     *
     */
    public $messages;


    /**
     * User that sent the message
     *
     * @var \App\User
     */
    public $user;


    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($messages)
    {
        //
        $messages->load(['user.information']);
        $this->messages = $messages;

        // $this->user = $user;

    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        // return new Channel('chat.'. $this->messages->thread_id);
        return new PresenceChannel('chat.' . $this->messages->thread_id);
    }
}
