<?php


namespace App\Repositories;
use App\Repositories\AbstractRepository as BaseRepository;
use App\Models\JoborderServiceSupplies;

class JoborderServiceSuppliesRepository extends BaseRepository
{
    protected function modelClass()
    {
        return new JoborderServiceSupplies;
    }


}
