<?php


namespace App\Services;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Repositories\VehicleRepository;
use App\Services\AbstractServices;
use App\Libraries\Http\Code;

class VehicleServices extends AbstractServices
{

    private $authUser;
    private $vehicle;

    public function __construct(VehicleRepository $VehicleRepository){
        try {
            $this->authUser = Auth::guard('api')->user();
        } catch (Exception $e) {
            \Log::info('No Auth User');
        }
        $this->vehicle = $VehicleRepository;
    }

    /**
    * Get the user or enterprise vehicles
    */
    public function getVehicles($request)
    {

        $search = $request->get('search',NULL);
        $sortBy = $request->get('sort_by','created_at');
        $sortDirection = $request->get('sort_direction','DESC');

        /**
         * Vehicle of Enterprise
         * for raise concern only
         * technician action
         * array
         */
        if($request->has('enterprise_only')){
            $vehicle = $this->vehicle->getEnterpriseVehicles();
            return $this->response('success', $vehicle, Code::HTTP_OK);
        }

        /**
         * All Vehicle of specific Enterprise
         *
         */
        if($request->has('enterprise_id'))
        {

            /**
             * Fetch Enterprise Vehicles
             * Paginated
             * For web
             */
            if($request->has('page') || $request->has('limit')) {

                $vehicle = $this->vehicle
                    ->addWhere(['enterprise_id' => $request->get('enterprise_id')])
                    ->addSearch($search)
                    ->addSortBy($sortBy,$sortDirection)
                    ->fetch(FALSE, FALSE, TRUE, $request->get('limit',15));

                return $this->response('success', $vehicle, Code::HTTP_OK);
            }

            /**
             * Fetch Enterprise Vehicles
             * Paginated
             * For mobile
             */
            $vehicle = $this->vehicle->getUserEnterpriseVehicles($request->get('enterprise_id'));

            return $this->response('success', $vehicle, Code::HTTP_OK);
        }

        /**
         * Get all vehicle of Users
         * array
         */
        $vehicle = $this->vehicle->getUserVehicles($this->authUser->id);

        return $this->response('success', $vehicle, Code::HTTP_OK);
    }


    /**
     * Vehicle Service history
     * Get vehicle by id
     */
    public function getVehicle($id,$request)
    {
        $vehicle = $this->vehicle->firstOrFail($id);

        if($request->has('service_history')){

            $vehicle = $this->vehicle->addWith(['joborders.items','joborders.user.information','joborders.enterprise','joborders.ratings','joborders.technicians.information'])->firstOrFail($id);

            return $this->response('success', $vehicle, Code::HTTP_OK);
        }
        return $this->response('success', $vehicle, Code::HTTP_OK);
    }


    /**
    * Create user vehicle
    */
    public function createVehicles($request){
         DB::beginTransaction();

         $vehicle = null;
         try{
            $data = [
                'make' => $request->get('make'),
                'model' => $request->get('model'),
                'year' => $request->get('year'),
                'variant' => $request->get('variant'),
                'mileage' => $request->get('mileage'),
                'fuel' => $request->get('fuel'),
                'plate_no' => $request->get('plate_no'),
                'engine_code' => $request->get('engine_code'),
                'chassis_code' => $request->get('chassis_code'),
                'aap_id_number' => $request->get('aap_id_number'),
            ];

             /**
              * if Vehicles is under enterprise or basic users
              */
            if($request->has('enterprise_id')){
                $data['enterprise_id'] = $request->get('enterprise_id');
                $data['user_id'] = null;
            }else{
                $data['user_id'] = $this->authUser->id;
            }

            $vehicle = $this->vehicle->create($data);

         }catch(Exception $e){
             DB::rollback();
             return $this->response('error',[ $e->getMessage() ], Code::HTTP_BAD_REQUEST);
         }
         DB::commit();

         return $this->response('success', $vehicle, Code::HTTP_CREATED);

    }

    /**
     * Update user vehicle
     *
     */
    public function updateVehicles($request,$id)
    {
        $vehicle = $this->vehicle->addWhere(['id' => $id])->fetch(TRUE,FALSE,FALSE);

        DB::beginTransaction();
        try {
            $data = [
                'mileage'           => $request->get('mileage', $vehicle->mileage),
                'plate_no'          => $request->get('plate_no', $vehicle->plate_no),
                'engine_code'       => $request->get('engine_code', $vehicle->engine_code),
                'chassis_code'      => $request->get('chassis_code', $vehicle->chassis_code),
                'aap_id_number'     => $request->get('aap_id_number', $vehicle->app_id_number),
            ];

            $this->vehicle->update(['id' => $id ], $data);

        }catch(Exception $e) {
            DB::rollback();

            return $this->response('error', $e->getMessage() , Code::HTTP_FAILED);
        }
        DB::commit();

        $vehicle = $this->vehicle->firstOrFail($id);

        return $this->response('success', $vehicle, Code::HTTP_CREATED);
    }


    /**
     *
     */
}
