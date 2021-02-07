<?php
/**
 * Created by PhpStorm.
 * User: rod
 * Date: 11/30/2019
 * Time: 6:16 PM
 */

namespace App\Repositories;
use App\Repositories\AbstractRepository as BaseRepository;
use App\Models\Wallets;

class UsersWalletRepository extends BaseRepository
{
    protected function modelClass()
    {
        return new Wallets;
    }
}