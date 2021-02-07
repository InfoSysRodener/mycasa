<?php
/**
 * Created by PhpStorm.
 * User: rod
 * Date: 11/30/2019
 * Time: 6:14 PM
 */

namespace App\Services;


use App\Repositories\UsersWalletRepository;
use App\Repositories\RewardRatesRepository;
use App\Repositories\UsersRepository;
use App\Libraries\Http\Code;
use DB;

class UsersWalletServices extends AbstractServices
{
    private $wallet;

    private $rewardRates;

    private $user;

    public function __construct(UsersRepository $userRepository,UsersWalletRepository $usersWalletRepository,RewardRatesRepository $rewardRatesRepository)
    {
        $this->user = $userRepository;
        $this->wallet = $usersWalletRepository;
        $this->rewardRates = $rewardRatesRepository;

    }


    /**
     * Get Convertion Rates
     */
    public function getConvertionRate()
    {
        $rate = $this->rewardRates->fetch(TRUE,FALSE,FALSE);
        return $this->response('success', $rate , Code::HTTP_OK);
    }

    /**
     * Create Wallets
     * @param $request
     */
    public function createWallets($userId)
    {
        DB::beginTransaction();
        $wallet = null;
        try {

            $data = [
                'reward_points' => 0,
                'lifetime_points' => 0,
                'user_id' => $userId,

            ];

           $wallet = $this->wallet->create($data);

        } catch (Exception $e){
            DB::rollback();

            return $this->response('error',[ $e->getMesasge() ],Code::HTTP_BAD_REQUEST);
        }
        DB::commit();

        return $wallet;
    }


    /**
     * Show Convertion Rate
     */
    public function showConvertionRate($id)
    {
        $rate = $this->rewardRates->firstOrFail($id);

        return $this->response('success', $rate , Code::HTTP_OK);
    }

    /**
     * Show Users Wallet
     *
     */
    public function showUserWallets($id)
    {

        $userWallet = $this->user->addWhere(['user_type' => 'consumer'])->addWith(['information','wallet'])->firstOrFail($id);

        return $this->response('success',$userWallet,Code::HTTP_OK);
    }

    /**
     * Set Convertion Rate
     * @param $request
     */
    public function setConvertionRate($request,$id)
    {

       $value = $request->get('value');
       $over_total = $request->get('over_total');

       $rate = $value / $over_total;

       $data = [
            'value' => floatval($value),
            'over_total' => floatval($over_total),
            'reward_convertion_rate' => floatval($rate)
       ];

       $this->rewardRates->update(['id' => $id], $data);

       $rate = $this->rewardRates->firstOrFail($id);

       return $this->response('success', $rate , Code::HTTP_OK);
    }



    /**
     * Get User Points
     *
     */
    public function getUserPoints($request)
    {
        $search = $request->get('search', NULL);
        $sortBy = $request->get('sort_by','created_at');
        $sortDirection = $request->get('sort_direction','DESC');

        $userWallet = $this->user
            ->addWith(['information','wallet'])
            ->addSearch($search)
            ->addWhere(['user_type' => 'consumer'])
            ->addSortBy($sortBy,$sortDirection)
            ->fetch(FALSE,FALSE,TRUE,$request->get('limit',15));

        return $this->response('success',$userWallet,Code::HTTP_OK);
    }




    /**
     * update User Points
     * @param $request
     */
    public function updateUserPoints($request,$userId)
    {

        $points = $request->get('points');
        $action = $request->get('action');

        $userWallet = $this->wallet->addWhere(['user_id' => $userId])->fetch(TRUE,FALSE,FALSE);

        DB::beginTransaction();

        try {
            /**
             * Create user wallets
             */
            if(is_null($userWallet) === TRUE){
                $userWallet = $this->createWallets($userId);
            }

            /**
             * If action increase Add points in lifetime points
             * @var [type]
             */
            if($action === 'increase'){
                $userWallet->lifetime_points = floatval($userWallet->lifetime_points) + $points;
            }

        }catch (Exception $e){
            DB::rollback();

            return $this->response('error',[ $e->getMesasge() ],Code::HTTP_BAD_REQUEST);
        }

        DB::commit();

        $userWallet->reward_points = floatval($userWallet->reward_points) + $points;
        $userWallet->save();
        $userWallet->fresh();

        return $this->response('success', $userWallet , Code::HTTP_OK);

    }


}
