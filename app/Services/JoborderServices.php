<?php


namespace App\Services;
use App\Events\ChatMessages;
use App\Libraries\Image\Upload;
use App\Libraries\PDF\pdf;
use App\Libraries\Random\Randomizer;
use App\Repositories\MessagesRepository;
use App\Repositories\UsersRepository;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Repositories\EnterpriseRepository;
use App\Services\AbstractServices;
use App\Repositories\JoborderRepository;
use App\Repositories\JoborderServiceSuppliesRepository;
use App\Repositories\BookingRepository;
use App\Repositories\VehicleRepository;
use App\Repositories\DeviceRepository;
use App\Libraries\Http\Code;
use App\Libraries\Push\Notification;

class JoborderServices extends AbstractServices
{

    private $authUser;

    private $joborder;

    private $booking;

    private $joborderItem;

    private $message;

    private $vehicle;

    private $device;

    private $user;

    public function __construct(JoborderRepository $joborderRepository,JoborderServiceSuppliesRepository $joborderServiceSuppliesRepository,BookingRepository $bookingRepository,VehicleRepository $vehicleRepository,MessagesRepository $messageRepository,DeviceRepository $deviceRepository,UsersRepository $usersRepository)
    {
        try {
            $this->authUser = Auth::guard('api')->user();
        } catch (Exception $e) {
            \Log::info('No Auth User');
        }
        $this->joborder = $joborderRepository;
        $this->joborderItem = $joborderServiceSuppliesRepository;
        $this->booking = $bookingRepository;
        $this->vehicle = $vehicleRepository;
        $this->message = $messageRepository;
        $this->device  = $deviceRepository;
        $this->user = $usersRepository;
    }

    /**
     *  Get Joborders
     *
     */
    public function getJoborders($request)
    {

        $status = $request->get('status','completed');
        $search = $request->get('search',NULL);
        $sortBy = $request->get('sort_by','created_at');
        $sortDirection = $request->get('sort_direction','DESC');

        $joborder = $this->joborder->addWith(['vehicle', 'user.information','technicians','items' ,'enterprise']);

        if($request->has('status') || $request->has('limit')){
            $joborder = $joborder
                ->addWhere(['status' => $status])
                ->addSearch($search)
                ->addOrderBy($sortBy, $sortDirection)
                ->fetch(FALSE, FALSE, TRUE, $request->get('limit',15));
            return $this->response('success',$joborder, Code::HTTP_OK);
        }

        /**
         * Get Joborders with Booking id
         * web front-end for display
         */
        if($request->has('booking_id')){
            $joborder = $this->joborder->addWhere(['booking_id' => $request->get('booking_id')])
                        ->addWith(['technicians','items'])->fetch(TRUE,FALSE,FALSE);
            return $this->response('success',$joborder, Code::HTTP_OK);
        }

        /**
         * Calendar View
         */
        $joborder = $joborder->addOrderBy($sortBy, $sortDirection)
                             ->fetchJobOrderDateRange($request);

        return $this->response('success',$joborder, Code::HTTP_OK);
    }

    /**
     * Create Joborder
     */
    public function createJoborder($request)
    {

        /** get array of object services & supplies */
        $item = $request->input('joborder_service_supplies');

        /**  get array of user id techinician */
        $technician_id = $request->input('technician_id');

        $chatCreated = null;

        $joborder = null;

        $user = $this->authUser;

        DB::beginTransaction();

        try {

            $data = [
                'requested_at'  => $request->get('requested_at',null),
                'completed_at'  => $request->get('completed_at',null),
                'concern'       => $request->get('concern',null),
                'assessment'    => $request->get('assessment',null),
                'solution'      => $request->get('solution',null),
                'branch_id'     => $request->get('branch_id',null),
                'vehicle_id'    => $request->get('vehicle_id'),
                'status'        => $request->get('status','pending'),
                'user_id'       => $request->get('user_id',null),
                'enterprise_id' => $request->get('enterprise_id',null),
                'concern_type'  => $request->get('concern_type',null),
                'schedule'      => $request->get('schedule',null),
                'location'      => $request->get('location',null),
                'booking_id'    => $request->get('booking_id',null),
                'total'         => $request->get('total',null)
            ];

            $joborder = $this->joborder->create($data);


            $joborder->load(['user.information.enterprise']);

            /**
             * Create Joborder Code
             */
            $this->joborder->update(['id' => $joborder->id],[
                'code' => sprintf('%04d',$joborder->id),
            ]);

            /**
             * Send Message
             * Dont Send Message If booking from Technician
             */
            if($joborder->user->user_type !== 'technician')
            {
                $threadId = md5($joborder->user_id);
                if($joborder->user->information->enterprise_id !== null){
                    $threadId = md5('enterprise-'.$joborder->user->information->enterprise->id);
                }

                $data = [
                    'thread_id'     => $threadId,
                    'user_id'       => $this->authUser->id,
                    'chat'          => 'Joborder Created #' . $joborder->joborder_id . $joborder->code,
                    'is_read'       => 'sent',
                    'joborder_id'   => $joborder->id,
                ];

                $chatCreated = $this->message->create($data);

                $chatCreated->load(['joborder']);

                /**
                 * Broadcast Messages
                 */
                broadcast(new ChatMessages($chatCreated))->toOthers();
            }


            /**
             * Update Booking status
             */
            if($request->has('booking_id') === TRUE)
            {
                $this->booking->update(['id' => $request->get('booking_id')],[
                    'status' => $request->get('status','pending')
                ]);
            }




            /**
             * Save Service And Supplies
             */
            foreach ($item as $key => $value)
            {
                 $value['joborder_id'] = $joborder->id;
                 $this->joborderItem->create((array)$value);
            }

            /**
             * Save Data in Pivot
             */
            $joborder->users()->attach($technician_id);

        }catch(Exception $e){
            DB::rollback();

            return $this->response('error',[ $e->getMessage() ],Code::HTTP_BAD_REQUEST);
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


            foreach ($participant as $key => $value){

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

        $joborder = $this->joborder->firstOrFail($joborder->id);

        return $this->response('success',$joborder,Code::HTTP_CREATED);
    }

    /**
     *  Update Joborder
     */
    public function updateJoborder($request,$id)
    {

        /** get array of object services & supplies */
        $item = $request->input('joborder_service_supplies');

        /**  get array of user id techinician */
        $technician_id = $request->input('technician_id');

        $joborder = $this->joborder->firstOrFail($id);

        $joborder->load(['user.information.enterprise']);

        DB::beginTransaction();

        try {

            /**
             * Cancel Joborders
             */
            if($request->has('cancel')){
                $this->cancelJoborders($id);
            }

            $data = [
                'requested_at'         => $request->get('requested_at', $joborder->requested_at),
                'concern'              => $request->get('concern', $joborder->concern),
                'assessment'           => $request->get('assessment', $joborder->assessment),
                'solution'             => $request->get('solution', $joborder->solution),
                'discount'             => $request->get('discont', $joborder->discount),
                'status'               => $request->get('status', $joborder->status),
                'check_up'             => $request->get('check_up', $joborder->check_up),
                'recommendations'      => $request->get('recommendations',$joborder->recommendations),
                'mileage'              => $request->get('mileage',$joborder->mileage),
                'feedback'             => $request->get('feedback',$joborder->feedback),
                'total'                => $request->get('total', $joborder->total),
                'location'             => $request->get('location', $joborder->location),
                'schedule'             => $request->get('schedule',$joborder->schedule)
            ];

            /**
             * Complete the joborders
             * Update completed_at
             */
            if($request->has('completed_at'))
            {
                $data['completed_at'] = Carbon::now();
            }

            /**
             * Upload Image
             */
            $image = null;
            if ($request->has('image') === TRUE) {
                $filename = date('U') . '_' . Randomizer::filename();
                $image = Upload::upload($request->file('image'), $filename, '/');
                $data['image'] = $image['filename'];
            }

            /**
             * Upload Client Signature Image
             */
            if($request->has('client_signature') === TRUE){
                $filename = date('U') . '_' . Randomizer::filename();
                $image = Upload::upload($request->file('client_signature'), $filename, '/');
                $data['client_signature'] = $image['filename'];
            }

            /**
             * Upload Technician Signature Image
             */
            if($request->has('technician_signature') === TRUE){
                $filename = date('U') . '_' . Randomizer::filename();
                $image = Upload::upload($request->file('technician_signature'), $filename, '/');
                $data['technician_signature'] = $image['filename'];
            }

            /**
             * Delete & Update Joborders Items
             */
            if($request->has('joborder_service_supplies')){

                /**
                 * Delete joborders item
                 */
                $this->joborderItem->deleteAllWhere(['joborder_id' => $id]);

                foreach ($item as $key => $value)
                {
                     $value['joborder_id'] = $id;
                     $this->joborderItem->create((array)$value);
                }
            }

            if($request->has('technician_id'))
            {
                /**
                 * Update joborder_user Data in Pivot
                 */
                $joborder->users()->sync($technician_id);
            }

            $this->joborder->update(['id' => $id], $data);

            /**
             * Update Vehicle mileage
             */
            if($request->has('mileage'))
            {
                $joborder = $this->joborder->firstOrFail($id);

                $this->vehicle->update(['id' => $joborder->vehicle_id],[
                    'mileage' => $request->get('mileage')
                ]);
            }

            /**
             * Update Booking Status
             */
            if($request->has('status')){
                $this->booking->update(['id' => $joborder->booking_id],[
                    'status' => $request->get('status')
                ]);
            }


        }catch(Exception $e){
            DB::rollback();

            return $this->response('error', $e->getMessage() ,Code::HTTP_BAD_REQUEST);
        }
        DB::commit();

        /**
         *  Send message if Joborders user type admin
         */


        if($this->authUser->user_type === 'admin'){

            /**
             * Send Message
             *
             */
            $threadId = md5($joborder->user_id);
            if($joborder->user->information->enterprise_id !== null){
                $threadId = md5('enterprise-'.$joborder->user->information->enterprise->id);
            }

            $data = [
                'thread_id'     => $threadId,
                'user_id'       => $this->authUser->id,
                'chat'          => null,
                'is_read'       => 'sent',
                'joborder_id'   => $joborder->id,
            ];

            $chatCreated = $this->message->create($data);

            $chatCreated->load(['joborder']);

            /**
            * Broadcast Messages
            */
            broadcast(new ChatMessages($chatCreated))->toOthers();
        }


        return $this->response('success', $joborder ,Code::HTTP_OK);

    }

    /**
     * Show specific job order
     */
    public  function showJoborder($id) {

        $joborder = $this->joborder->addWith(['vehicle', 'user.information', 'users','items' ,'enterprise','ratings','booking'])->firstOrFail($id);

        return $this->response('success',$joborder,Code::HTTP_CREATED);
    }

    /**
     * Cancel Joborders
     * Technician
     */
    public function cancelJoborders($id)
    {

       $techinician = $this->authUser;

       $joborder = $this->joborder->firstOrFail($id);

       DB::beginTransaction();

       try {
           /**
            * Remove Technician from joborders
            */
           $joborder->users()->detach($techinician->id);

       } catch (Exception $e) {
           DB::rollback();

           return $this->response('error', [ $e->getMessage() ] ,Code::HTTP_BAD_REQUEST);
       }
       DB::commit();

       return $this->response('success',$joborder,Code::HTTP_CREATED);
    }

    /**
     * ADMIN
     * Create Booking with Joborders
     * Portal
     */
    public function createCostEstimate($request)
    {

        $user_id = $request->get('user_id');

        $vehicle_id = $request->get('vehicle_id',null);

        $location = $request->get('location',null);

        $city = $request->get('city',null);

        /** get array of object services & supplies */
        $item = $request->input('joborder_service_supplies');

        /**  get array of user id techinician */
        $technician_id = $request->input('technician_id');


        DB::beginTransaction();

        /**
         * Get users
         */
        $user = $this->user
            ->addWith(['information.enterprise.vehicles','vehicles'])
            ->firstOrfail($user_id);

        try{
            /**
             * Create Bookings
             */
            $data = [
                'vehicle_id'    => $vehicle_id,
                'address'       => $request->get('address',''),
                'concern'       => $request->get('concern',''),
                'concern_type'  => $request->get('concern_type',null),
                'date'          => $request->get('date',null),
                'time'          => $request->get('time',null),
                'status'        => $request->get('status','pending'),
                'booked_by'     => $this->authUser->user_type
            ];

            /**
             * Consumer type Request
             */
            if($user->user_type === 'consumer')
            {
                $data['user_id'] = $user->id;
                $data['location'] =  $location;
                $data['city'] = $city;
            }

            /**
             * Enterprise Type Request
             */
            if($user->user_type === 'enterprise')
            {
                $data['user_id'] = $user->id;
                $data['enterprise_id'] = $user->information->enterprise_id;
            }

            /** booking created */
            $booking = $this->booking->create($data);

            /**
             * Create Joborders
             */
            $data = [
                'requested_at'  => $request->get('requested_at',null),
                'concern'       => $request->get('concern',null),
                'assessment'    => $request->get('assessment',null),
                'solution'      => $request->get('solution',null),
                'vehicle_id'    => $vehicle_id,
                'status'        => $request->get('status','pending'),
                'user_id'       => $user->id,
                'concern_type'  => $request->get('concern_type',null),
                'schedule'      => $request->get('schedule',null),
                'location'      => $request->get('location',null),
                'city'          => $city,
                'booking_id'    => $booking->id,
                'total'         => $request->get('total',null)
            ];

            /**
             * Enterprise Type Request
             */
            if($user->user_type === 'enterprise')
            {
                $data['enterprise_id'] = $user->information->enterprise_id;
            }

            $joborder = $this->joborder->create($data);

            $joborder->load(['user.information.enterprise']);

            /**
             * Create Joborder Code
             */
            $this->joborder->update(['id' => $joborder->id],[
                'code' => sprintf('%04d',$joborder->id),
            ]);


            /**
             * Send Message
             */
            $threadId = md5($joborder->user_id);
            if($joborder->user->information->enterprise_id !== null){
                $threadId = md5('enterprise-'.$joborder->user->information->enterprise->id);
            }

            $data = [
                'thread_id'     => $threadId,
                'user_id'       => $this->authUser->id,
                'chat'          => 'Joborder Created #' . $joborder->joborder_id . $joborder->code,
                'is_read'       => 'sent',
                'joborder_id'   => $joborder->id,
            ];

            $chatCreated = $this->message->create($data);

            $chatCreated->load(['joborder']);

            /**
             * Broadcast Messages
             */
            broadcast(new ChatMessages($chatCreated))->toOthers();

            /**
             * Update Booking status
             */
            if($request->has('booking_id') === TRUE)
            {
                $this->booking->update(['id' => $booking->id],[
                    'status' => $request->get('status','pending')
                ]);
            }

            /**
             * Save Service And Supplies
             */
            foreach ($item as $key => $value)
            {
                $value['joborder_id'] = $joborder->id;
                $this->joborderItem->create((array)$value);
            }

            /**
             * Save Data in Pivot
             */
            $joborder->users()->attach($technician_id);

        }catch(Exception $e){
            DB::rollback();

            return $this->response('error',[ $e->getMessage() ],Code::HTTP_BAD_REQUEST);
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


            foreach ($participant as $key => $value){

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

        $joborder = $this->joborder->firstOrFail($joborder->id);

        return $this->response('success',$joborder,Code::HTTP_CREATED);

    }



    /**
     * Generate Service Reports
     */
    public function generateServiceReport($request)
    {

        $joborder_id = $request->get('joborder_id');

        $joborder = $this->joborder->addWith(['vehicle', 'user.information', 'technicians.information', 'items' , 'enterprise', 'ratings'])->firstOrFail($joborder_id);

//         return  $joborder;
       ini_set('max_execution_time', 180);
       $pdf =  pdf::upload_service_report($joborder, 'pdf');

       return $pdf;
    }

    /**
     * Generate Cost Estimate
     */
    public function generateCostEstimate($request)
    {
        $joborder_id = $request->get('joborder_id');

        $joborder = $this->joborder->addWith(['vehicle', 'user.information', 'technicians.information', 'items' , 'enterprise', 'ratings'])->firstOrFail($joborder_id);

        ini_set('max_execution_time', 180);
        $pdf =  pdf::upload_cost_estimate($joborder, 'pdf');

        return $pdf;
    }
}
