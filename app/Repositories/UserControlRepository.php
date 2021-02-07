<?php
/**
 * Created by PhpStorm.
 * User: rod
 * Date: 2/21/2020
 * Time: 4:35 PM
 */

namespace App\Repositories;

use App\Repositories\AbstractRepository as BaseRepository;
use App\Models\UserControls;


class UserControlRepository extends BaseRepository
{
    protected function modelClass()
    {
        return new UserControls;
    }
}