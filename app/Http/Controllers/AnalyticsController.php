<?php

namespace App\Http\Controllers;

use App\Services\AnalyticsServices;
use Illuminate\Http\Request;

class AnalyticsController extends Controller
{

    private $analytics;

    public function __construct(AnalyticsServices $analyticsServices)
    {
        $this->analytics = $analyticsServices;
    }

    /**
     * Joborders Analytics
     */
    public function jobordersAnalytics(Request $request)
    {
        return $this->analytics->joborderAnalytics($request);
    }


    /**
     * Vehicle Analytics
     */
    public function vehicleAnalytics(Request $request)
    {
        return $this->analytics->vehicleAnalytics($request);
    }
}
