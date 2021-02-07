<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//use  App\Http\Requests\JobordersRequest as Request;
use App\Services\JoborderServices;

class JobordersController extends Controller
{

    private $joborder;
    public function __construct(JoborderServices $JoborderServices)
    {
        $this->joborder = $JoborderServices;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return $this->joborder->getJoborders($request);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        return $this->joborder->createJoborder($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id,Request $request)
    {
        return $this->joborder->showJoborder($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        return $this->joborder->updateJoborder($request,$id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }


    /**
     * @param Request $request
     * @return \App\Services\json
     * Create Cost Estimate
     * Admin
     */
    public function createCostEstimate(Request $request)
    {
        return $this->joborder->createCostEstimate($request);
    }


    /**
     * Generate Service Report
     */
    public function generateServiceReport(Request $request)
    {
        return $this->joborder->generateServiceReport($request);
    }

    /**
     * Generate Cost Estimate Report
     */
    public function generateCostEstimate(Request $request)
    {
        return $this->joborder->generateCostEstimate($request);
    }
}
