<?php


namespace App\Services;
use App\Libraries\Http\Code;
use App\Repositories\GroupMessagesRepository;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Pagination\LengthAwarePaginator;
use Log;

class GroupMessagesServices extends AbstractServices
{

    private $authUser;
    private $groupMessages;

    public function __construct(GroupMessagesRepository $groupMessagesRepository){
        try {
            $this->authUser = Auth::guard('api')->user();
        } catch (Exception $e) {
            Log::info('No Auth User');
        }
        $this->groupMessages = $groupMessagesRepository;
    }


    /**
     * Group Message list // thread
     * Group Message list Count
     */
    public function getGroupMessages($request)
    {

        $category = $request->get('category');

        /**
         * Group Message
         * Inbox Count
         */
        if($request->has('category') === FALSE || $request->has('count'))
        {

            $groupMessages_inbox = $this->groupMessages->groupMessageThread('inbox');
            $groupMessages_inquiry = $this->groupMessages->groupMessageThread('inquiry');
            $groupMessages_pending = $this->groupMessages->groupMessageThread('pending');
            $groupMessages_open = $this->groupMessages->groupMessageThread('open');
            $groupMessages_closed = $this->groupMessages->groupMessageThread('closed');

            $inbox = 0;
            $inquiry = 0;
            $pending = 0;
            $open = 0;
            $closed = 0;


            /**
             * Inbox
             */
            foreach($groupMessages_inbox  as $key => $groupMessage)
            {
                $inbox += $groupMessage->unread_messages_count;
            }

            /**
             * Inquiry
             */
            foreach($groupMessages_inquiry  as $key => $groupMessage)
            {
                foreach($groupMessage->participant as $keys => $participant){
                    if(count($participant->user->bookings) !== 0)
                    {
                        $inquiry += $groupMessage->unread_messages_count;
                    }
                }
            }

            /**
             * Pending
             */
            foreach($groupMessages_pending as $key => $groupMessage)
            {
                foreach($groupMessage->participant as $keys => $participant){
                    if(count($participant->user->user_joborders) !== 0)
                    {
                        $pending += $groupMessage->unread_messages_count;
                    }
                }
            }

            /**
             * Open
             */
            foreach($groupMessages_open as $key => $groupMessage)
            {
                foreach($groupMessage->participant as $keys => $participant){
                    if(count($participant->user->user_joborders) !== 0)
                    {
                        $open += $groupMessage->unread_messages_count;
                    }
                }
            }

            /**
             * Closed
             */
            foreach($groupMessages_closed as $key => $groupMessage)
            {
                foreach($groupMessage->participant as $keys => $participant){
                    if(count($participant->user->user_joborders) !== 0)
                    {
                        $closed += $groupMessage->unread_messages_count;
                    }
                }
            }

            $data = [
                'inbox' => $inbox,
                'inquiry' => $inquiry,
                'pending' => $pending,
                'open'  => $open,
                'closed' => $closed
            ];

            return $this->response('success',$data ,Code::HTTP_OK);
        }


        /**
         * GroupMessage Thread List
         */

        $groupMessages = $this->groupMessages->groupMessageThread($category);

        foreach($groupMessages  as $key => $groupMessage)
        {

            /**
             *  all thread list
             *
             */
           if($category !== 'inbox')
           {

               if($category === 'inquiry')
               {
                    /**
                     * Remove if all users in a thread that no booking
                     *
                     */
                   $count = 0;
                   foreach($groupMessage->participant as $keys => $participant){
                        if(count($participant->user->bookings) !== 0)
                        {
                            $count++;
                        }
                   }

                   if($count === 0){
                      $groupMessages->forget($key);
                   }
               }
               else {
                  /**
                    * Remove if all users in a thread that no joborders
                    *
                    */
                   $count = 0;
                   foreach($groupMessage->participant as $keys => $participant){
                        if(count($participant->user->user_joborders) !== 0)
                        {
                            $count++;
                        }
                   }

                   if($count === 0){
                      $groupMessages->forget($key);
                   }
                }
           }
        }

        /**
         * Sort by based on last message timestamp
         */
        $groupMessages = $groupMessages->sortByDesc('message.created_at');


        /**
         * Convert Array to Pagination
         *
         */
        $messages = $groupMessages->values()->toArray();


        $page = Input::get('page', 1); // Get the ?page=1 from the url
        $perPage = 15; // Number of items per page
        $offset = ($page * $perPage) - $perPage;

        $messages = new LengthAwarePaginator(
                 array_slice($messages, $offset, $perPage, true), // Only grab the items we need
                 count($messages), // Total items
                 $perPage, // Items per page
                 $page, // Current page
                 ['path' => $request->url(), 'query' => $request->query()] // We need this so we can keep all old query parameters from the url
        );

        return  $this->response('success', $messages ,Code::HTTP_OK);



    }
}
