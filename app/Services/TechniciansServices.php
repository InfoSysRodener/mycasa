<?php

namespace App\Services;
use App\Libraries\Image\Upload;
use App\Libraries\Random\Randomizer;
use App\Libraries\Http\Code;
use App\Repositories\TechniciansRepository;
use App\Services\AbstractServices;
use DB;

class TechniciansServices extends AbstractServices
{
    private $technician;


    public function __construct(TechniciansRepository $techniciansRepository) {
        $this->technician = $techniciansRepository;

    }

    public function index($request)
    {
        $search = $request->get('search',NULL);
        $sortBy = $request->get('sort_by','created_at');
        $sortDirection = $request->get('sort_direction','DESC');
        $technicians = null;

        if($request->has('limit')){
            $technicians = $this->technician
                ->addWith(['information'])
                ->addWhere(['user_type' => "technician"])
                ->addSearch($search)
                ->addSortBy($sortBy,$sortDirection)
                ->fetch(FALSE, FALSE, TRUE, $request->limit);

            return $this->response('success',$technicians , Code::HTTP_OK);
        }

        $technicians = $this->technician
            ->addWith(['information'])
            ->addWhere(['user_type' => 'technician'])
            ->addSearch($search)
            ->addSortBy($sortBy,$sortDirection)
            ->fetch(FALSE, FALSE, FALSE);


        return $this->response('success',$technicians , Code::HTTP_OK);
    }

    /**
     * Store to service table
     *
     * @param  Illuminate\Http\Request $request
     * @return JSON
     */
    public function create($request) {

        /**
        * Upload Image
        * Upload Image with thumbnail version
        */
        $image = $this->uploadProfile($request);

        $data = [
            'email'                     => $request->get('email'),
            'mobile_number'             => $request->get('mobile_number'),
            'password'                  => bcrypt($request->get('password')),
            'email_verified_at'         => null,
            'mobile_number_verified_at' => null,
            'user_type'                 => 'technician',

            'fullname'                  => $request->get('fullname'),
            'address'                   => $request->get('address', null),
            'gender'                    => $request->get('gender'),
            'birthdate'                 => $request->get('birthdate', null),
            'branch'                    => $request->get('branch', null),
            'profile'                   => $image,
            'branch_id'                 => $request->get('branch_id',null),
            'enterprise_id'             => $request->get('enterprise_id',null),
        ];


        $service = DB::transaction(function() use ($data) {
            $user = $this->technician->create($data);

            /**
            * Create Users Information
            */
            $user->information()->create([
                'fullname'       => $data['fullname'],
                'address'        => $data['address'],
                'gender'         => $data['gender'],
                'birthdate'      => $data['birthdate'],
                'user_id'        => $user->id,
                'branch_id'      => $data['branch_id'],
                'enterprise_id'  => $data['enterprise_id'],
                'profile'        => $data['profile']
            ]);

            return $user;

        }, 2);

        return $this->response('success', $service, Code::HTTP_CREATED);
    }

    /**
     * Show specific service
     *
     * @param service_id $id
     * @return JSON
     */
    public function show($id) {
        return $this->technician->addWith(['information'])->firstOrFail($id);
    }

    /**
     * Update service
     *
     * @param Illuminate\Http\Request $request
     * @param service_id $id
     */
    public function update($request, $id) {
        /**
        * Upload Image
        * Upload Image with thumbnail version
        */
        $image = $this->uploadProfile($request);

        $argument = [
            'id' => $id
        ];

        $data = [
            'email'                     => $request->get('email'),
            'mobile_number'             => $request->get('mobile_number'),
            'password'                  => bcrypt($request->get('password')),
            'email_verified_at'         => null,
            'mobile_number_verified_at' => null,
            'user_type'                 => 'technician',
        ];

        $information = [
            'fullname'                  => $request->get('fullname'),
            'address'                   => $request->get('address', null),
            'gender'                    => $request->get('gender'),
            'birthdate'                 => $request->get('birthdate', null),
            'profile'                   => $image,
            'branch_id'                 => $request->get('branch_id',null),
            'enterprise_id'             => $request->get('enterprise_id',null),
        ];

        $service = DB::transaction(function() use ($argument, $data, $information) {
            $user = $this->technician->update($argument, $data);

            $userInformation = $this->technician->getUserInfomation($argument['id'], $information);

            return $this->technician->firstOrFail($argument['id']);
        }, 2);

        return $this->response('success', $service, Code::HTTP_CREATED);
    }


    /**
     * Upload Image
     * Helper Function
     * @param $request
     * @return string|null
     */
    private function uploadProfile($request){
        $image = null;

        if ($request->has('profile') === TRUE) {
            $filename = date('U') . '_' . Randomizer::filename();
            $image = Upload::upload($request->file('profile'), $filename . '_thumb', '/', TRUE);
            $image = Upload::upload($request->file('profile'), $filename . '_480', '/', FALSE, 480);
            $image = Upload::upload($request->file('profile'), $filename, '/');
            $image = $image['filename'];
        }

        return $image;
    }


}
