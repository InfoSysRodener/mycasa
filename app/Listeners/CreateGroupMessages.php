<?php

namespace App\Listeners;

use App\Events\ChatCreated;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Repositories\GroupMessagesRepository;
use App\Repositories\ParticipantsRepository;

class CreateGroupMessages
{
    /**
     * Create the event listener.
     *
     * @return void
     */

    private $groupMessages;

    private $participant;

    public function __construct(GroupMessagesRepository $groupMessagesRepository,ParticipantsRepository $participantsRepository)
    {
        //
        $this->groupMessages = $groupMessagesRepository;
        $this->participant = $participantsRepository;
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
         * Check if Conversation Exists
         */
        $groupExists = $this->groupMessages->groupMessageExists($event->threadId);

        if(is_null($groupExists) === TRUE)
        {

            $data = [
                'title' => $event->request->get('title',$event->title),
                'creator_id' => $event->userId,
                'thread_id' => $event->request->get('thread_id',$event->threadId),
            ];

            /**
             * Create Group Message
             */
            $groupMessage = $this->groupMessages->create($data);

            /**
             * Save Data in Pivot
             */
            $groupMessage->users()->attach($event->userId);
        }
    }
}
