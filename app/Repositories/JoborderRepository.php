<?php


namespace App\Repositories;
use App\Repositories\AbstractRepository as BaseRepository;
use App\Models\Joborder;

class JoborderRepository extends BaseRepository
{
    protected function modelClass()
    {
        return new Joborder;
    }

    
    /**
     *  Fetch All Job Order depeding on date
     */
    public function fetchJobOrderDateRange($request)
    { 
        $from = $request->from .' 00:00:00';
        $to = $request->to .' 23:59:59';
        // $from = $request->from;
        // $to = $request->to;
        return $this->model->whereBetween('schedule', [$from, $to])->get();
    }

    /**
     * Joborders Count
     * @param $column
     * @param $value
     * @return mixed
     */
    public function joborderCount($column,$value)
    {
        if($value === 'open'){
            return $this->model->where($column,'!=','pending')->where($column,'!=','completed')->count();
        }
        return $this->model->where($column,$value)->count();
    }



    public function addSearch($query = NULL)
    {
        if(is_null($query) === TRUE) return $this;

        $this->model = $this->model->where(function ($q) use ($query){
            $q->where('location','LIKE', '%' . $query . '%')
                ->orWhere('concern','LIKE', '%' . $query . '%')
                ->orWhere('requested_at','LIKE', '%' . $query . '%');
        })->orWhereHas('vehicle',function ($q) use ($query){
            $q->where('make', 'LIKE', '%' . $query . '%')
                ->orWhere('model','LIKE', '%' . $query . '%')
                ->orWhere('year','LIKE', '%' . $query . '%')
                ->orWhere('plate_no','LIKE', '%' . $query . '%');
        })->orWhereHas('user.information',function ($q) use ($query){
            $q->where('fullname', 'LIKE', '%' . $query . '%');
        })->orWhereHas('enterprise',function ($q) use ($query){
            $q->where('prefix', 'LIKE', '%' . $query . '%');
            $q->orWhere('name', 'LIKE', '%' . $query . '%');
        });

        return $this;
    }

    public function addOrderBy($sortBy,$direction)
    {
        $this->model = $this->model
            ->select('joborders.*')
            ->leftJoin('user_informations','joborders.user_id','=','user_informations.user_id')
            ->leftJoin('vehicles','joborders.vehicle_id','=','vehicles.id')
            ->leftJoin('enterprises','joborders.enterprise_id','=','enterprises.id')
            ->orderBy($sortBy,$direction);

        return $this;
    }
}
