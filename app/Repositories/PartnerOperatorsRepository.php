<?php

namespace App\Repositories;
use App\Repositories\AbstractRepository as BaseRepository;
use App\Models\PartnerOperators;

class PartnerOperatorsRepository extends BaseRepository
{
    protected function modelClass()
    {
        return new PartnerOperators;
    }
}
