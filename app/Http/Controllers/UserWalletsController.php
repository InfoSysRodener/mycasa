<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\UsersWalletServices;

class UserWalletsController extends Controller
{

    private $userWallet;

    public function __construct(UsersWalletServices $usersWalletServices)
    {
        $this->userWallet = $usersWalletServices;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        return $this->userWallet->getUserPoints($request);
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

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        return $this->userWallet->showUserWallets($id);
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
        return $this->userWallet->updateUserPoints($request,$id);

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
     * Show Convertion Rate
     */
    public function showRate($id)
    {
        return $this->userWallet->showConvertionRate($id);
    }


    /**
     * Get Conversation Rate
     */
    public function getRate()
    {
        return $this->userWallet->getConvertionRate();
    }

    /**
     * Update Conversation Rate
     */
    public function setRate(Request $request, $id)
    {
        return $this->userWallet->setConvertionRate($request,$id);
    }

}
