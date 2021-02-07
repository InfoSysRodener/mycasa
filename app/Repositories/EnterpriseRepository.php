<?php


namespace App\Repositories;
use App\Repositories\AbstractRepository as BaseRepository;
use App\Models\Enterprise;

class EnterpriseRepository extends BaseRepository
{
    protected function modelClass()
    {
        return new Enterprise;
    }

    /**
     * Search
     */
    public function addSearch($query)
    {
        if(is_null($query) === TRUE) return $this;

        $this->model = $this->model->where(function ($q) use ($query){
            $q->where('prefix', 'LIKE', '%' . $query . '%')
                ->orWhere('name','LIKE', '%' . $query . '%');
        });

        return $this;
    }


    /**
     * add SortBy
     */
    public function addSortBy($sortBy,$direction)
    {
        $this->model = $this->model
            ->orderBy($sortBy,$direction);

        return $this;
    }
}
