<?php


namespace App\Repositories;
use App\Repositories\AbstractRepository as BaseRepository;
use App\Models\Booking;

class BookingRepository extends BaseRepository
{
    protected function modelClass()
    {
        return new Booking;
    }

    public function addSearch($query = NULL)
    {
        if(is_null($query) === TRUE) return $this;

        $this->model = $this->model->where(function ($q) use ($query){
                $q->where('status', 'LIKE', '%' . $query . '%')
                    ->orWhere('bookings.address','LIKE', '%' . $query . '%')
                    ->orWhere('concern','LIKE', '%' . $query . '%')
                    ->orWhere('concern_type','LIKE', '%' . $query . '%')
                    ->orWhere('date','LIKE', '%' . $query . '%')
                    ->orWhere('time','LIKE', '%' . $query . '%')
                    ->orWhereHas('enterprise',function ($q) use ($query){
                        $q->where('prefix', 'LIKE', '%' . $query . '%');
                        $q->orWhere('name', 'LIKE', '%' . $query . '%');
                    })->orWhereHas('vehicle',function ($q) use ($query){
                        $q->where('make', 'LIKE', '%' . $query . '%')
                            ->orWhere('model','LIKE', '%' . $query . '%')
                            ->orWhere('year','LIKE', '%' . $query . '%')
                            ->orWhere('plate_no','LIKE', '%' . $query . '%');
                    })->orWhereHas('user.information',function ($q) use ($query){
                        $q->where('fullname', 'LIKE', '%' . $query . '%');
                    });
        });

        return $this;
    }

    public function addOrderBy($sortBy,$direction)
    {

        $this->model = $this->model
            ->select('bookings.*')
            ->leftJoin('user_informations','bookings.user_id','=','user_informations.user_id')
            ->leftJoin('vehicles','bookings.vehicle_id','=','vehicles.id')
            ->leftJoin('enterprises','bookings.enterprise_id','=','enterprises.id')
            ->orderBy($sortBy,$direction);

        return $this;
    }
}
