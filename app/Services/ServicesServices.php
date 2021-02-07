<?php

namespace App\Services;
use App\Libraries\Http\Code;
use App\Repositories\ServicesRepository;
use App\Services\AbstractServices;
use DB;

class ServicesServices extends AbstractServices
{

    private $services;

    public function __construct(ServicesRepository $servicesRepository)
    {
        $this->services = $servicesRepository;
    }

    public function index($request)
    {

        /**
         * Get Services Paginated
         *
         */
        if($request->get('limit'))
        {
           $services = $this->services->fetch(FALSE, FALSE, TRUE, $request->get('limit'));
        }


        /**
         * Gel all services
         *
         */
         $services = $this->services->fetch(FALSE, TRUE, FALSE);


        return $this->response('success',$services,Code::HTTP_OK);

    }

    /**
     * Store to service table
     *
     * @param  Illuminate\Http\Request $request
     * @return JSON
     */
    public function create($request)
    {
        DB::beginTransaction();
        try {

            $data = [
                'name'          => $request->get('name'),
                'size'          => $request->get('size'),
                'title'         => $request->get('title'),
                'price'         => $request->get('price'),
                'category'      => $request->get('category'),
                'description'   => $request->get('description')
            ];

            $services = $this->services->create($data);

        } catch (Exception $e){
            DB::rollback();

            return $this->response('error',[ $e->getMessage() ],Code::HTTP_OK);
        }

        DB::commit();

        return $this->response('success',$services,Code::HTTP_OK);

    }

    /**
     * Show specific service
     *
     * @param service_id $id
     * @return JSON
     */
    public function show($id)
    {

        $services = $this->servicesRepository->firstOrFail($id);

        return $this->response('success',$services,Code::HTTP_OK);
    }

    /**
     * Update service
     *
     * @param Illuminate\Http\Request $request
     * @param service_id $id
     */
    public function update($request, $id)
    {

        $services = $this->servicesRepository->firstOrFail($id);

        DB::beginTransaction();
        try {

            $data = [
                'name'          => $request->get('name',$services->name),
                'size'          => $request->get('size',$services->size),
                'title'         => $request->get('title',$services->title),
                'price'         => $request->get('price',$service->price),
                'category'      => $request->get('category',$services->category),
                'description'   => $request->get('description',$services->description)
            ];

            $this->services->update(['id' => $id], $data);

        } catch (Exception $e) {
            DB::rollback();

            return $this->response('error',[ $e->getMessage() ],Code::HTTP_OK);
        }

        DB::commit();

        $services = $this->servicesRepository->firstOrFail($id);

        return $this->response('success',$services,Code::HTTP_OK);

    }
}
