<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\DeviceServices;

class DeviceController extends Controller
{

    private $device;

    public function __construct(DeviceServices $deviceServices)
    {
        $this->device = $deviceServices;
    }

    public function registerDevice(Request $request)
    {
        return $this->device->registerDevice($request);
    }

    public function unregisterDevice(Request $request)
    {
        return $this->device->unregisterDevice($request);
    }
}
