<?php


namespace App\Repositories;
use App\Repositories\AbstractRepository as BaseRepository;
use App\Models\User;
use function foo\func;

class UsersRepository extends BaseRepository
{
	protected function modelClass()
    {
        return new User;
    }

    /**
    * Find Email or Mobile Number
    */
    public function findUsername($username)
    {
        $this->model = $this->model
            ->Where('email',            $username)
            ->orWhere('mobile_number',  $username);

        return $this;
    }

    /**
    * Show password
    */
    public function showPassword($model)
    {
        if (is_null($model) === false) {
            $model->makeVisible(['password']);
        }

        return $model;
    }

    /**
     * Search
     */
    public function addSearch($query = NULL)
    {
        if(is_null($query) === TRUE) return $this;

        $this->model = $this->model->orWhere(function ($q) use ($query){
             $q->where('email', 'LIKE', '%' . $query . '%')
                ->orWhere('mobile_number','LIKE', '%' . $query . '%');
        })->orWhereHas('information',function ($q) use ($query) {
             $q->where('fullname', 'LIKE', '%' . $query . '%')
                ->orWhere('gender','LIKE', '%' . $query . '%')
                ->orWhere('birthdate','LIKE', '%' . $query . '%')
                ->orWhere('address','LIKE', '%' . $query . '%');
        })->orWhereHas('wallet',function ($q) use ($query) {
            $q->where('reward_points', 'LIKE', '%' . $query . '%')
                ->orWhere('lifetime_points', 'LIKE', '%' . $query . '%');
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
            ->leftJoin('wallets','users.id','=','wallets.user_id')
            ->orderBy($sortBy,$direction);

        return $this;
    }
}
