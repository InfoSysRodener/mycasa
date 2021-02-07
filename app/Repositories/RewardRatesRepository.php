<?php


namespace App\Repositories;
use App\Repositories\AbstractRepository as BaseRepository;
use App\Models\RewardRate;

class RewardRatesRepository extends BaseRepository
{
    protected function modelClass()
    {
        return new RewardRate;
    }


}
