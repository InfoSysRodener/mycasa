<?php
/**
 * Created by PhpStorm.
 * User: rod
 * Date: 11/11/2019
 * Time: 10:39 PM
 */

namespace App\Services;
use App\Libraries\Http\Code;
use App\Repositories\DeviceRepository;
use App\Services\AbstractServices;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Libraries\Push\Notification;

class DeviceServices extends AbstractServices
{

    private $device;

    private $user;

    public function __construct(DeviceRepository $deviceRepository)
    {
        $this->device = $deviceRepository;
        $this->user = Auth::guard('api')->user();
    }


    public function registerDevice($request)
    {
        $deviceToken = trim($request->get('device_token'));
        $platform = $request->get('platform');

        DB::beginTransaction();
        try {

            /**
             * Check if Devices Exists
             */
            $device = $this->device
                     ->addWhere(['device_token' => $deviceToken])
                     ->fetch(TRUE,FALSE,FALSE);


            if ($device === null) {

                /**
                 * Do not create Devices Token
                 * if Technician
                 */
                if($this->user->user_type !== 'technician'){


                    // register to SNS
                    $data = Notification::registerToken($deviceToken, $platform);

                    //subscribe Device To Topic
                    $subscribe = Notification::subscribe($data['EndpointArn']);

                    /**
                     * Create User Devices
                     */
                    $this->device->create([
                        'device_token'      => $deviceToken,
                        'platform'          => $platform, //android or ios
                        'user_id'           => $this->user->id,
                        'arn'               => $data['EndpointArn'],
                        'subscription_arn'  => $subscribe
                    ]);
                }

            }

        } catch (Exception $e) {
            DB::rollback();

            return $this->response('error',[$e->getMessage()],Code::HTTP_BAD_REQUEST);
        }
        DB::commit();

        return $this->response('success',['Successfully Register'],Code::HTTP_OK);
    }


    public function unregisterDevice($request)
    {
        /**
         * Check Device Token
         *
         */
        $device = $this->device
            ->addWhere(['device_token' => $request->get('device_token')])
            ->addWhere(['user_id' => $this->user->id])
            ->fetch(TRUE,FALSE,FALSE);

        if(is_null($device) === TRUE){
            return $this->response('error',['Cannot unsubscribe device token'],Code::HTTP_OK);
        }
        /**
         * UnSubscribe The Devices
         */
        Notification::unSubscribe($device->arn,$device->subscription_arn);
        $this->device->delete($device->id);
        // $device->save();

        return $this->response('success',['Successfully Unregister'],Code::HTTP_OK);
    }

}
