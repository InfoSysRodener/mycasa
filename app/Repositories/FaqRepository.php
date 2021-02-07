<?php


namespace App\Repositories;
use App\Repositories\AbstractRepository as BaseRepository;
use App\Models\Faqs;

class FaqRepository extends BaseRepository
{
    protected function modelClass()
    {
        return new Faqs;
    }


}
