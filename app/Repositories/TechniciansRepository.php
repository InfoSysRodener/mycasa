<?php

namespace App\Repositories;
use App\Repositories\AbstractRepository as BaseRepository;
use App\Models\User;
use App\Models\UserInformation;

class TechniciansRepository extends BaseRepository
{
    protected function modelClass()
    {
        return new User;
    }

    public function getUserInfomation($id, $information){
        // return $id;
        return UserInformation::updateOrCreate(
            ['user_id' => $id],
            $information
        );
    }


    /**
     * Search
     */
    public function addSearch($query)
    {
        if(is_null($query) === TRUE) return $this;

        $this->model = $this->model->where(function ($q) use ($query){
            $q->where('email', 'LIKE', '%' . $query . '%')
                ->orWhere('mobile_number','LIKE', '%' . $query . '%');
        })->orWhereHas('information',function ($q) use ($query) {
            $q->where('fullname', 'LIKE', '%' . $query . '%')
                ->orWhere('gender','LIKE', '%' . $query . '%')
                ->orWhere('birthdate','LIKE', '%' . $query . '%')
                ->orWhere('address','LIKE', '%' . $query . '%');
        });

        return $this;
    }

    /**
     * add SortBy
     */
    public function addSortBy($sortBy,$direction)
    {
        $this->model = $this->model
            ->select('users.*')
            ->leftJoin('user_informations','users.id','=','user_informations.user_id')
            ->orderBy($sortBy,$direction);

        return $this;
    }
}
