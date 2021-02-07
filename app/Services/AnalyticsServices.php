<?php

/**
 * Created by PhpStorm.
 * User: rod
 * Date: 12/31/2019
 * Time: 4:06 PM
 */

namespace App\Services;


use App\Libraries\Http\Code;
use App\Repositories\JoborderRepository;
use App\Repositories\VehicleRepository;
use function GuzzleHttp\Promise\all;
use Illuminate\Support\Facades\DB;

class AnalyticsServices extends AbstractServices
{

    private $joborders;
    private $vehicle;

    public function __construct(JoborderRepository $joborderRepository,VehicleRepository $vehicleRepository)
    {
        $this->joborders = $joborderRepository;
        $this->vehicle = $vehicleRepository;
    }

    /**
     * Joborder Analytics
     */
    public function joborderAnalytics($request)
    {
        /**
         * Joborders Count
         */
        if($request->has('status'))
        {
            $status = $request->get('status');

            if($status === 'all'){
                $pending = $this->joborders->joborderCount('status','pending');
                $open = $this->joborders->joborderCount('status','open');
                $completed = $this->joborders->joborderCount('status','completed');

                $data = [
                    'pending' => $pending,
                    'open'    => $open,
                    'completed'   => $completed
                ];

                return $this->response('success',$data,Code::HTTP_OK);
            }

            /**
             * Joborders Count By Status
             */
            $completed = $this->joborders->joborderCount('status',$status);

            $data = [
                'completed'   => $completed
            ];

            return $this->response('success',$data,Code::HTTP_OK);

        }


    }

    /**
     * Vehicle Analytics
     * @param $request
     */
    public function vehicleAnalytics($request)
    {
        /**
         * Get Total of Vehicle
         */
        if($request->has('total')){

            $vehicle =  (object) [
                'total' => $this->vehicle->addCount()
            ];
            return $this->response('success',$vehicle,Code::HTTP_OK);
        }

        /**
         * Get Vehicle
         * Group by Make
         */
        if($request->has('group_by')){

            $group_by = $request->get('group_by');

            $vehicle = $this->vehicle
                ->addSelect([DB::raw('COUNT(id) as value'),'make'])
                ->addGroupBy($group_by)
                ->fetch(FALSE,TRUE,FALSE);

            return $this->response('success',$vehicle,Code::HTTP_OK);
        }

    }
}

