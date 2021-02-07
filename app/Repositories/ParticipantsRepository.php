<?php


namespace App\Repositories;
use App\Repositories\AbstractRepository as BaseRepository;
use App\Models\Participant;

class ParticipantsRepository extends BaseRepository
{
    protected function modelClass()
    {
        return new Participant;
    }

}
