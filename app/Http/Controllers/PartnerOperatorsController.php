<?php

namespace App\Http\Controllers;
use App\Services\PartnerOperatorsServices;

use Illuminate\Http\Request;

class PartnerOperatorsController extends Controller
{
    //
    private $partnerOperatorsServices;

    // public function __construct(PartnerOperatorsServices $partnerOperatorsServices){
    //     $this->partnerOperatorsServices = $partnerOperatorsServices;
    // }

    public function index(Request $request) {
        return [
            'data' => [
                [
                    'id' => 1,
                    'firstName' => 'Sample',
                    'lastName' => "Operator",
                    'contactNumber' => 639999488881,
                    'address' => 'Mandaluyong',
                    'gender' => 'Female',
                    'birthdate' => '2012-10-16',
                    'email' => 'test@test.com',
                    'password' => 'fourello',
                    'branch' => 'Boni',
                    'position' => 'Developer'
                ]
            ]
        ];
        return $this->partnerOperatorsServices->index($request);
    }

    public function store(Request $request) {
        return [
            'id' => 1,
            'firstName' => 'Sample',
            'lastName' => "Operator",
            'contactNumber' => 639999488881,
            'address' => 'Mandaluyong',
            'gender' => 'Female',
            'birthdate' => '2012-10-16',
            'email' => 'test@test.com',
            'password' => 'fourello',
            'branch' => 'Boni',
            'position' => 'Developer'
        ];
        return $this->partnerOperatorsServices->create($request);
    }

    public function show($id) {
        return [
            'id' => 1,
            'firstName' => 'Sample',
            'lastName' => "Operator",
            'contactNumber' => 639999488881,
            'address' => 'Mandaluyong',
            'gender' => 'Female',
            'birthdate' => '2012-10-16',
            'email' => 'test@test.com',
            'password' => 'fourello',
            'branch' => 'Boni',
            'position' => 'Developer'
        ];
        return $this->partnerOperatorsServices->show($id);
    }

    public function update(Request $request, $id) {
        return [
            'id' => 1,
            'firstName' => 'Sample',
            'lastName' => "Operator",
            'contactNumber' => 639999488881,
            'address' => 'Mandaluyong',
            'gender' => 'Female',
            'birthdate' => '2012-10-16',
            'email' => 'test@test.com',
            'password' => 'fourello',
            'branch' => 'Boni',
            'position' => 'Developer'
        ];
        return $this->partnerOperatorsServices->update($request, $id);
    }

}
