<?php

namespace App\Services;
use App\Libraries\Http\Code;
use App\Repositories\PartnerOperatorsRepository;
use DB;

class PartnerOperatorsServices
{
    public function __construct(PartnerOperatorsRepository $partnerOperatorsRepository) {
        $this->partnerOperatorsRepository = $partnerOperatorsRepository;
    }

    public function index($request) {
        return $this->partnerOperatorsRepository->fetch(FALSE, FALSE, TRUE, $request->limit);
    }

    /**
     * Store to service table
     *
     * @param  Illuminate\Http\Request $request
     * @return JSON
     */
    public function create($request) {
        $data = [
            'name' => $request->name,
            'size' => $request->size,
            'title' => $request->title,
            'price' => $request->price,
            'category' => $request->category,
            'description' => $request->description
        ];

        $service = DB::transaction(function() use ($data) {
            return $this->partnerOperatorsRepository->create($data);
        }, 2);


        return $service;
    }

    /**
     * Show specific service
     *
     * @param service_id $id
     * @return JSON
     */
    public function show($id) {
        return $this->partnerOperatorsRepository->firstOrFail($id);
    }

    /**
     * Update service
     *
     * @param Illuminate\Http\Request $request
     * @param service_id $id
     */
    public function update($request, $id) {
        $argument = [
            'id' => $id
        ];

        $data = [
            'name' => $request->name,
            'size' => $request->size,
            'title' => $request->title,
            'price' => $request->price,
            'category' => $request->category,
            'description' => $request->description
        ];

        return $this->partnerOperatorsRepository->update($argument, $data);
    }
}
