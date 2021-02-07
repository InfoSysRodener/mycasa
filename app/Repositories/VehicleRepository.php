<?php


namespace App\Repositories;
use App\Repositories\AbstractRepository as BaseRepository;
use App\Models\Vehicle;

class VehicleRepository extends BaseRepository
{
    protected function modelClass()
    {
        return new Vehicle;
    }

    /**
     * Get enterprise vehicles
     */
    public function getEnterpriseVehicles(){
        return $this->model->where('user_id', null)->get();
    }

    /**
     * Get user vehicles
     */
    public function getUserVehicles($user_id)
    {
        return $this->model->where('user_id', $user_id)->get();
    }

    /**
     * Get vehicle of enterprise user
     */
    public function getUserEnterpriseVehicles($enterprise_id)
    {
        return $this->model->where('enterprise_id',$enterprise_id)->get();
    }


    /**
 * Search
 */
    public function addSearch($query)
    {
        if(is_null($query) === TRUE) return $this;

        $this->model = $this->model->where(function ($q) use ($query){
            $q->where('make', 'LIKE', '%' . $query . '%')
                ->orWhere('model','LIKE', '%' . $query . '%')
                ->orWhere('year','LIKE', '%' . $query . '%')
                ->orWhere('variant','LIKE', '%' . $query . '%')
                ->orWhere('fuel','LIKE', '%' . $query . '%')
                ->orWhere('plate_no','LIKE', '%' . $query . '%');
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
