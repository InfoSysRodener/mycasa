<?php

namespace App\Http\Controllers;
use App\Services\UsersServices;
use App\Http\Requests\UsersRequest;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    //
    private $user;
    public function __construct(UsersServices $UsersServices){
        $this->user = $UsersServices;
    }

    /*
     ** Users Login
     */
    public function login(Request $request){
        return $this->user->loginUser($request);
    }

    /*
     ** Users Register
     */
    public function register(UsersRequest $request){
        return $this->user->createUser($request);
    }

    /*
     ** Users Profile
     */
    public function show(Request $request, $id){
        return $this->user->showProfile($id);
    }

    /*
     ** Users self Profile
     */
    public function self(){
        return $this->user->selfProfile();
    }

    /**
     * Update Users Self Profile
     */
    public function updateSelf(Request $request)
    {
        return $this->user->updateSelf($request);
    }

    /**
     * Update Users by id
     */
    public function updateUser(Request $request,$id)
    {
        return $this->user->updateUser($request,$id);
    }

    /**
     * Users Logout
     */
    public function logout(){
        return $this->user->logoutUser();
    }

    /**
      * Get User
      */
    public function index(Request $request){
        return $this->user->index($request);
    }


    /**
      *  Get User Joborders
      */
    public function joborders(Request $request){
        return $this->user->userJoborders($request);
    }


    /**
      *  Get User Joborders Scheduled
      */
    public function jobordersScheduled(){
        return $this->user->userJoborderScheduled();
    }


    /**
      * Get User All Joborders
      */
    public function jobordersAll()
    {
        return $this->user->userAllJoborders();
    }


    /**
     * Change Password
     */
    public function changePassword(Request $request){
        return $this->user->changePassword($request);
    }

    /**
     * Confirm Password
     */
    public function confirmPassword(Request $request){
        return $this->user->confirmPassword($request);
    }

    /**
     * Login with Facebook
     */
    public function loginWithFacebook(Request $request)
    {
        return $this->user->loginWithFacebook($request);
    }

    /**
     * Forgot Password
     */
    public function forgotPassword(Request $request)
    {
        return $this->user->forgotPassword($request);
    }


    /**
     * Reset Password View
     */
    public function reset(Request $request)
    {
        return $this->user->reset($request);
    }

    /**
     * Reset Password
     */
    public function resetPassword(Request $request)
    {
        return $this->user->resetPassword($request);
    }
}
