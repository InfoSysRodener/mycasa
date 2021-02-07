<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::prefix('v2')->group(function () {
    Route::prefix('users')->group(function (){
        Route::post('register','UsersController@register');
        Route::post('login', 'UsersController@login');
        Route::post('logout','UsersController@logout');
        Route::get('self','UsersController@self')->middleware('auth:api');
        Route::post('self','UsersController@updateSelf')->middleware('auth:api');
        Route::put('{id}','UsersController@updateUser')->middleware('auth:api');
        Route::post('confirm/password','UsersController@confirmPassword')->middleware('auth:api');
        Route::post('change/password','UsersController@changePassword')->middleware('auth:api');
        Route::get('{id}', 'UsersController@show');
    });


    /**
     * facebook Login
     */
    Route::post('login/facebook','UsersController@loginWithFacebook');


    /**
     * Forgot Password
     */
    Route::post('forgot/password','UsersController@forgotPassword');

    /**
     * Generate Sevice Report
     */
    Route::get('joborder/generate/service_report','JobordersController@generateServiceReport');
    Route::get('joborder/generate/cost_estimate','JobordersController@generateCostEstimate');
});


Route::group(['prefix' => 'v2','middleware' => ['auth:api']], function () {

         /**
          * messages resource
          */
         Route::apiResource('message', 'MessagesController');
         Route::any('message/update','MessagesController@updateMessageStatus');

         /**
          * Group Message resource
          */
         Route::apiResource('group/message','GroupMessageController');


         /**
          * vehicle resource
          */
         Route::apiResource('vehicle','VehiclesController');

         /**
          * bookings resource
          */
         Route::apiResource('booking','BookingsController');

         /**
          * Ads resource
          */
         Route::apiResource('ads','AdsController');

         /**
          * FAQ resource
          */
         Route::apiResource('faq','FaqController');

         /**
          * Enterprise resource
          */
         Route::apiResource('enterprise','EnterpriseController');

         /**
          * Joborder resource
          */
         Route::apiResource('joborder','JobordersController');
         Route::post('joborder/costestimate','JobordersController@createCostEstimate');


         /**
          * Ratings resource
          */
         Route::apiResource('rating','RatingsController');

         /**
          * Branch resource
          */
         Route::apiResource('branch','BranchController');

         /**
          * Services resource
          */
         Route::resource('services', 'ServicesController');


         /**
          * Products resource
          */
         Route::resource('products', 'ProductsController');

         /**
          * Technicians resource
          */
         Route::resource('technicians', 'TechniciansController');

         /**
          * Partner operatiors resource
          */
         Route::resource('partner-operators', 'PartnerOperatorsController');

         /**
          * Users Resource
          * Users Joborders
          */
         Route::get('user/joborders','UsersController@joborders');
         Route::get('user/joborders/scheduled','UsersController@jobordersScheduled');
         Route::get('user/joborders/all','UsersController@jobordersAll');
         Route::resource('users', 'UsersController');

         /**
          * Users Wallet Resource
          *
          */
         Route::get('convertion/rate/{id}','UserWalletsController@showRate');
         Route::get('convertion/rate','UserWalletsController@getRate');
         Route::put('convertion/rate/{id}','UserWalletsController@setRate');
         Route::apiResource('user/wallet','UserWalletsController');


         /**
          * Users Devices
          */
         Route::post('register/device','DeviceController@registerDevice');
         Route::post('unregister/device','DeviceController@unregisterDevice');


         /**
          * Analytics Routes
          */
         Route::prefix('analytics')->group(function (){
             Route::get('joborders','AnalyticsController@jobordersAnalytics');
             Route::get('vehicle','AnalyticsController@vehicleAnalytics');
         });
});




