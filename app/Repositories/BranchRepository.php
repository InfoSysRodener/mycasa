<?php
/**
 * Created by PhpStorm.
 * User: rod
 * Date: 11/11/2019
 * Time: 10:37 PM
 */

namespace App\Repositories;
use App\Repositories\AbstractRepository as BaseRepository;
use App\Models\Branch;


class BranchRepository extends BaseRepository
{
    protected function modelClass()
    {
        return new Branch;
    }
}