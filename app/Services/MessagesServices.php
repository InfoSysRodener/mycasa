<?php

namespace App\Services;
use App\Events\MessageDelivered;
use App\Events\UsersOnline;
use App\Repositories\BookingRepository;
use App\Repositories\MessagesRepository;
use App\Repositories\DeviceRepository;
use Exception;
use Illuminate\Support\Facades\Auth;
use App\Libraries\Http\Code;
use App\Libraries\Image\Upload;
use App\Libraries\Push\Notification;
use App\Events\ChatMessages;
use App\Services\AbstractServices;
use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\DB;
use App\Events\ChatCreated;

class MessagesServices extends AbstractServices
{

    private $authUser;

    private $booking;

    private $message;

    private $device;

    public function __construct(MessagesRepository $messagesRepository, BookingRepository $bookingRepository,DeviceRepository $deviceRepository)
    {

        $this->booking = $bookingRepository;
        $this->message = $messagesRepository;
        $this->device  = $deviceRepository;

        try {
            $this->authUser = Auth::guard('api')->user();
        } catch (Exception $e) {
            \Log::info('No Auth User');
        }
    }

    /**
     * Get user message paginated
     * web
     */
    public function getMessages($request, $id)
    {


        $message = $this->message->addWhere(['thread_id' => $id])
            ->addWith(['user.information', 'joborder.enterprise', 'booking.vehicle'])
            ->addOrder('created_at', 'DESC');


        $message = $message->fetch(FALSE, FALSE, TRUE, 30);

        return $this->response('success', $message, Code::HTTP_OK);
    }


    /**
     * Get Logged Users Message paginated
     * Get Self Message
     * token based
     */
    public function getUserMessages($request)
    {

        $user = $this->authUser;
        $threadId = md5($user->id);

        /**
         * Check if user is enterprise
         */
        if ($user->user_type === 'enterprise') {
            $user->load(['information']);
            $threadId = md5('enterprise-' . $user->information->enterprise_id);
            $title = $user->information->enterprise->prefix;
        }


        $message = $this->message->addWhere(['thread_id' => $threadId])
            ->addWith(['user.information', 'joborder.enterprise','joborder.items','booking.vehicle'])
            ->addOrder('created_at', 'DESC');


        $message = $message->fetch(FALSE, FALSE, TRUE, 30);

        /**
         * Broadcast Users Online
         */
        broadcast(new UsersOnline($user))->toOthers();

        return $this->response('success', $message, Code::HTTP_OK);
    }


    /**
     * Create the message
     */
    public function createChat($request)
    {

        $chatCreated = null;
        $user = $this->authUser;
        $user->load(['information']);

        $threadId = md5($user->id);
        $chatCreated = null;
        $title = $user->information->fullname;

        /**
         * Check if user is enterprise
         */
        if ($user->user_type === 'enterprise') {

            $threadId = md5('enterprise-' . $user->information->enterprise_id);
            $title = $user->information->enterprise->prefix;
        }

        DB::beginTransaction();

        try {
            /**
             * Create Data Message
             */
            $data = [
                'thread_id' => $request->get('thread_id', $threadId),
                'user_id' => $user->id,
                'chat' => $request->get('chat', ''),
                'is_read' => 'sent'
            ];

            /**
             * Upload Image in Messages
             */
            if ($request->has('image') === TRUE) {
                $filename = date('U') . '_' . Randomizer::filename();
                $image = Upload::image($request->file('image'), $filename, '/');
                $data['image'] = $image['filename'];
            }

            $chatCreated = $this->message->create($data);

            /**
             * Event
             * Create GroupMessage
             * Create Participant
             */
            event(new ChatCreated($request, $user->id, $chatCreated->thread_id, $title));

        } catch (Exception $e) {
            DB::rollback();
            return $this->response('error', [ $e->getMessage() ], Code::HTTP_BAD_REQUEST);
        }
        DB::commit();


        /**
         * Send SNS Notification
         */
        if($user->user_type === 'admin'){

            /**
             * Get All Users of Thread Id
             */
            $participant = $this->message->addWhere(['thread_id' => $chatCreated->thread_id])->addGroupBy('user_id')->fetch(FALSE,TRUE,FALSE);

            foreach ($participant as $key => $value) {

                /**
                 * Get All Devices of Users
                 */
                $device = clone $this->device;
                $usersDevice = $device->addWhere(['user_id' => $value['user_id']])->fetch(FALSE,TRUE,FALSE);

                /**
                 * Send Notif To ALl Mobile
                 */
                if(count($usersDevice) !== 0){

                    foreach ($usersDevice as $key => $value){

                         Notification::sendToArn($chatCreated->chat,$value,['data' => $chatCreated],'mycasa_message');
                    }
                }
            }

        }


        /**
         * Broadcast Messages
         */
        broadcast(new ChatMessages($chatCreated))->toOthers();


        /**
         * Broadcast Users Online
         */
        broadcast(new UsersOnline($user,$chatCreated,'seen'))->toOthers();

        return $this->response('success', $chatCreated, Code::HTTP_CREATED);
    }


//    /**
//     * Get all thread
//     */
//    public function getAllThread($request)
//    {
//        $threadCategory = $request->get('category');
//
//        $messages  = $this->message->threadList($threadCategory)->toArray();
//
//        // $thread = [];
//        // foreach ($messages as $message)
//        // {
//        //     if($message->joborders !== null)
//        //     {
//        //         foreach ($message['joborders'] as $joborder)
//        //         {
//        //             if($joborder['status'] === $threadCategory)
//        //             {
//        //                 $message['badge'] = $this->message->readCount($message['user_id']);
//        //                 array_push($thread, $message);
//        //             }
//        //         }
//        //     }
//        // }
//
//        $page = Input::get('page', 1); // Get the ?page=1 from the url
//        $perPage = 15; // Number of items per page
//        $offset = ($page * $perPage) - $perPage;
//
//        $messages = new LengthAwarePaginator(
//                 array_slice($messages, $offset, $perPage, true), // Only grab the items we need
//                 count($messages), // Total items
//                 $perPage, // Items per page
//                 $page, // Current page
//                 ['path' => $request->url(), 'query' => $request->query()] // We need this so we can keep all old query parameters from the url
//        );
//        return  $this->response('success', $messages ,Code::HTTP_OK);
//    }


    /**
     * Update Message status
     *
     */
     public function  updateStatus($request)
     {

        $threadId = $request->get('thread_id', NULL);

        $status = $request->get('status','delivered');

        $user = $this->authUser;

        try{

            $data = [
                'is_read' => $status
            ];

            /**
             * Update all message
             */
            $this->message->updateMessageStatus($user,$threadId,$data);


            /**
             * Broadcast Message Status
             */
            broadcast(new MessageDelivered($threadId,$status))->toOthers();

        }catch (Exception $e){

            return $this->response('error',  $e->getMessage() , Code::HTTP_BAD_REQUEST);

        }
        return  $this->response('success',"Update Message Successfully" ,Code::HTTP_OK);
     }
}
