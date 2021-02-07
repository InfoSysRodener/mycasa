<?php

namespace App\Http\Controllers;
use App\Services\TechniciansServices;

use Illuminate\Http\Request;

class TechniciansController extends Controller
{
    //
    private $techniciansServices;

    public function __construct(TechniciansServices $techniciansServices){
        $this->techniciansServices = $techniciansServices;
    }

    public function index(Request $request)
    {
        return $this->techniciansServices->index($request);

    }

    public function store(Request $request) {
        return $this->techniciansServices->create($request);
    }

    public function show($id) {
        return $this->techniciansServices->show($id);
    }

    public function update(Request $request, $id) {
        return $this->techniciansServices->update($request, $id);
    }

    public function getAll(Request $request) {
        return $this->techniciansServices->getAll($request);
    }

}
