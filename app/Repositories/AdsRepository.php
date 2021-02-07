<?php


namespace App\Repositories;
use App\Repositories\AbstractRepository as BaseRepository;
use App\Models\Ads;

class AdsRepository extends BaseRepository
{
    protected function modelClass()
    {
        return new Ads;
    }

}
