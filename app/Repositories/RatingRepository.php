<?php


namespace App\Repositories;
use App\Repositories\AbstractRepository as BaseRepository;
use App\Models\Ratings;

class RatingRepository extends BaseRepository
{
    protected function modelClass()
    {
        return new Ratings;
    }


}
