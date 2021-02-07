<?php


namespace App\Repositories;
use App\Repositories\AbstractRepository as BaseRepository;
use App\Models\Devices;

class DeviceRepository extends BaseRepository
{
    protected function modelClass()
    {
        return new Devices;
    }

    // public function
}
