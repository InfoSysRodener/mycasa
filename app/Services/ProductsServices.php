<?php

namespace App\Services;
use App\Libraries\Http\Code;
use App\Repositories\ProductsRepository;
use DB;

class ProductsServices
{
    public function __construct(ProductsRepository $productsRepository) {
        $this->productsRepository = $productsRepository;
    }

    public function index($request) {
        return $this->productsRepository->fetch(FALSE, FALSE, TRUE, $request->limit);
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
            'prize' => $request->price,
            'category' => $request->category,
            'description' => $request->description
        ];

        $service = DB::transaction(function() use ($data) {
            return $this->productsRepository->create($data);
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
        return $this->productsRepository->firstOrFail($id);
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
            'prize' => $request->price,
            'category' => $request->category,
            'description' => $request->description
        ];

        return $this->productsRepository->update($argument, $data);
    }
}
