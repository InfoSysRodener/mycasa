<?php

namespace App\Repositories;
use App\Repositories\AbstractRepository as BaseRepository;
use App\Models\Services;

class ServicesRepository extends BaseRepository
{
    protected function modelClass()
    {
        return new Services;
    }
}
