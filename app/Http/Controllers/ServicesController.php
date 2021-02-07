<?php

namespace App\Http\Controllers;
use App\Services\ServicesServices;

use Illuminate\Http\Request;

class ServicesController extends Controller
{
    //
    private $servicesServices;

    public function __construct(ServicesServices $servicesServices){
        $this->services = $servicesServices;
    }

    public function index(Request $request) {
        return $this->services->index($request);
    }

    public function store(Request $request) {
        return $this->services->create($request);
    }

    public function show($id) {
        return $this->services->show($id);
    }

    public function update(Request $request, $id) {
        return $this->services->update($request, $id);
    }

}
