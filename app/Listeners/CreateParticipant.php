<?php

namespace App\Listeners;

use App\Events\ChatCreated;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Repositories\ParticipantsRepository;
use App\Repositories\GroupMessagesRepository;

class CreateParticipant
{
    /**
     * Create the event listener.
     *
     * @return void
     */

    private $participant;

    private $groupMessage;

    public function __construct(ParticipantsRepository $participantsRepository,GroupMessagesRepository $groupMessagesRepository)
    {
        $this->participant = $participantsRepository;
        $this->groupMessages = $groupMessagesRepository;
    }

    /**
     * Handle the event.
     *
     * @param  ChatCreated  $event
     * @return void
     */
    public function handle(ChatCreated $event)
    {

        /**
         * Get the Conversation
         */
        $groupMessage = $this->groupMessages->groupMessageExists($event->threadId);

        \Log::info($groupMessage->id);
        if(is_null($groupMessage) === FALSE){

            /**
             * Check if participant and user exists
             */
            $participantExist = $this->participant->addWhere(['group_message_id' => $groupMessage->id])
                ->addWhere(['user_id' => $event->userId])->fetch(TRUE,FALSE,FALSE);

            \Log::info('participant');
            \Log::info($participantExist);

            if(is_null($participantExist) === TRUE){

                $data = [
                    'group_message_id' => $groupMessage->id,
                    'user_id' => $event->userId,
                ];

                $this->participant->create($data);
            }
        }





    }
}
