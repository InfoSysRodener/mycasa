<?php


namespace App\Services;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Repositories\BookingRepository;
use App\Repositories\MessagesRepository;
use App\Events\ChatMessages;
use App\Services\AbstractServices;
use App\Libraries\Http\Code;
use App\Events\ChatCreated;

class BookingServices extends AbstractServices
{

    /** Auth User */
    private $authUser;

    /** Booking */
    private $booking;

    /** Message */
    private $message;

    public function __construct(BookingRepository $bookingRepository,MessagesRepository $messagesRepository){
        try{
            $this->authUser = Auth::guard('api')->user();
        } catch (Exception $e) {
            \Log::info('No Auth User');
        }
        $this->booking = $bookingRepository;
        $this->message = $messagesRepository;
    }


    /**
     * Get all Booking
     */
    public function getBooking($request)
    {
        $search = $request->get('search', NULL);
        $sortBy = $request->get('sort_by','created_at');
        $sortDirection = $request->get('sort_direction','DESC');

        $booking = $this->booking
            ->addWhereCondition('status','!=','scheduled')
            ->addWhereCondition('status','!=','completed')
            ->addSearch($search)
            ->addOrderBy($sortBy,$sortDirection)
            ->addWith(['user.information', 'vehicle', 'enterprise']);

        if($request->has('page') || $request->has('limit'))
        {
            /**
             * Po or Enterprise Admin
             */
            if($this->authUser->user_type === 'enterprise_admin' || $this->authUser->user_type === 'po')
            {
                $this->authUser->load(['controls.enterprise_controls']);

                $enterprise_array_id = $this->authUser->controls->enterprise_controls->toArray();
                $city_array = $this->authUser->controls->location_controls->toArray();
                $service_array = $this->authUser->controls->services_controls->toArray();
                $concern_array = $this->authUser->controls->concern_controls->toArray();

                /**
                 * if consumer is true
                 */
                if($this->authUser->controls['consumer'] == TRUE){
                    $booking->addWhere(['enterprise_id' => null]);
                }

                /**
                 * if user type is enterprise admin
                 */
                if($this->authUser->user_type === 'enterprise_admin'){
                    $booking->addWhereIn(array_column($concern_array,'concern_type') ,'bookings.concern_type');
                }

                /**
                 * if user type is po
                 */
                if($this->authUser->user_type === 'po'){
                    $booking->addWhereIn(array_column($service_array,'service_category') ,'bookings.service_category');
                }

                $booking = $booking
                    ->addWhereIn(array_column($enterprise_array_id,'enterprise_id') ,'bookings.enterprise_id')
                    ->addWhereIn(array_column($city_array,'city') ,'bookings.city')
                    ->fetch(FALSE, FALSE, TRUE, $request->get('limit',15));

                return $this->response('success', $booking , Code::HTTP_OK);
            }

            $booking = $booking->fetch(FALSE, FALSE, TRUE, $request->get('limit',15));

            return $this->response('success', $booking , Code::HTTP_OK);
        }

        $booking = $booking->fetch(FALSE, TRUE, FALSE);

        return $this->response('success', $booking , Code::HTTP_OK);
    }


    /**
     * Create Booking
     */
    public function createBooking($request)
    {

        DB::beginTransaction();

        $booking = null;

        $user = $this->authUser;

        try{
            $data = [
                'vehicle_id'    => $request->get('vehicle_id',null),
                'address'       => $request->get('address',''),
                'concern'       => $request->get('concern',''),
                'concern_type'  => $request->get('concern_type',null),
                'date'          => $request->get('date',null),
                'time'          => $request->get('time',null),
                'status'        => $request->get('status','pending'),
                'booked_by'     => $user->user_type
            ];

            /**
             * Consumer type Request
             */
            if($this->authUser->user_type === 'consumer')
            {
                $data['user_id'] = $user->id;
                $data['location'] =  $request->get('location',null);
                $data['city'] =  $request->get('city',null);
            }

            /**
             * Enterprise Type Request
             */
            if($this->authUser->user_type === 'enterprise')
            {
                $user->load(['information']);
                $data['user_id'] = $user->id;
                $data['enterprise_id'] = $user->information->enterprise_id;
            }


            /**
             * Technician Concern Booking
             * Technician Type Request
             */
            if($this->authUser->user_type === 'technician')
            {
                $data['user_id'] = $user->id;
                $data['enterprise_id'] = $request->get('enterprise_id',null);
            }


            $booking = $this->booking->create($data);


        }
        catch(Exception $e){
            DB::rollback();

            return $this->response('error',[ $e->getMessage() ],Code::HTTP_BAD_REQUEST);
        }
        DB::commit();

        /**
         * After Booking
         * Check booking if created by user or enteprise
         * Create Message
         */
        if($request->has('enterprise_id') === FALSE || $this->authUser->user_type !== 'technician')
        {
            $threadId = md5($user->id);
            $user->load(['information']);
            $title = $user->information->fullname;

            /**
             * Check if user is enterprise
             */
            if ($user->user_type === 'enterprise') {
                $threadId = md5('enterprise-' . $user->information->enterprise_id);
                $title = $user->information->enterprise->prefix;
            }

            $data = [
                'thread_id'     => $threadId,
                'user_id'       => $user->id,
                'chat'          => null,
                'is_read'       => 'sent',
                'booking_id'    => $booking->id,
            ];

            $chatCreated = $this->message->create($data);

            $chatCreated->load(['booking.vehicle']);

            /**
             * Event
             * Create GroupMessage
             * Create Participant
             */
            event(new ChatCreated($request, $user->id, $chatCreated->thread_id, $title));

            /**
             * Broadcast Messages
             */
            broadcast(new ChatMessages($chatCreated))->toOthers();


        }

        $booking = $this->booking->addWith('user.information')->firstOrFail($booking->id);

        return $this->response('success', $booking , Code::HTTP_CREATED);
    }


    /**
     * Update Booking
     */
    public function updateBooking($request,$id)
    {

        $booking = $this->booking->addWhere(['id' => $id])->fetch(TRUE,FALSE,FALSE);

        DB::beginTransaction();

        try {
            $data = [
                'address'       => $request->get('address',$booking->address),
                'concern'       => $request->get('concern',$booking->concern),
                'concern_type'  => $request->get('concern_type',$booking->concern_type),
                'date'          => $request->get('date',$booking->date),
                'time'          => $request->get('time',$booking->time),
                'status'        => $request->get('status',$booking->status),
            ];

            $this->booking->update(['id' => $id], $data);

        }catch(Exception $e){
            DB::rollback();

            return $this->response('error',[ $e->getMessage() ],Code::HTTP_BAD_REQUEST);
        }
        DB::commit();

        $booking = $this->booking->firstOrFail($id);

        return $this->response('success', $booking , Code::HTTP_OK);
    }

    /**
     * Show Bookings
     */
    public function showBooking($id)
    {
        $booking = $this->booking->addWith(['user.information', 'vehicle', 'enterprise'])->firstOrFail($id);
        return $this->response('success',$booking,Code::HTTP_OK);
    }

}
