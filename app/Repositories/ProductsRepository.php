<?php

namespace App\Repositories;
use App\Repositories\AbstractRepository as BaseRepository;
use App\Models\Products;

class ProductsRepository extends BaseRepository
{
    protected function modelClass()
    {
        return new Products;
    }
}
