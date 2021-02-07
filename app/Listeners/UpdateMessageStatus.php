<?php

namespace App\Listeners;

use App\Events\MessageDelivered;
use App\Events\UsersOnline;
use App\Models\Message;
use App\Repositories\MessagesRepository;
use App\Repositories\ParticipantsRepository;
use App\Services\MessagesServices;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UpdateMessageStatus
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    private $message;
    private $participant;
    public function __construct(MessagesRepository $messagesRepository,ParticipantsRepository $participantsRepository)
    {
        //
        $this->message = $messagesRepository;
        $this->participant = $participantsRepository;
    }

    /**
     * Handle the event.
     *
     * @param  UsersOnline  $event
     * @return void
     */
    public function handle(UsersOnline $event)
    {
        //
        $user = $event->user;
        $status = $event->status;
        $message = $event->message;

        $conversations = $this->participant->addWith(['conversation','user'])->addWhere(['user_id' => $user['id']])->fetch(FALSE,TRUE,FALSE);

        $data = [
            'is_read' =>  $status
        ];

        if(is_null($message) === TRUE)
        {
            foreach ($conversations as $conversation)
            {
                $this->message->updateMessageStatus((object) $user,$conversation['conversation']['thread_id'],$data);

                /**
                 * Broadcast update message
                 */
                broadcast(new MessageDelivered($conversation['conversation']['thread_id'], $status ))->toOthers();
            }
        }
        else
        {
            $this->message->updateMessageStatus((object) $user,$event->message->thread_id,$data);

            /**
             * Broadcast update message
             */
            broadcast(new MessageDelivered($event->message->thread_id, $status ))->toOthers();
        }



    }
}
