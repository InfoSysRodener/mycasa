<?php

namespace App\Http\Requests;

use App\Http\Requests\AbstractRequest as FormRequest;
use App\Models\Booking;
use Illuminate\Support\Facades\Auth;

class BookingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $user = Auth::guard('api')->user();

        if($this->method() === 'POST'){
            return $user->can('create', Booking::class);
        }
        if($this->method() === 'PUT'){

            $requestedId = (int)$this->route()->parameters['booking'];
            $requested = Booking::find($requestedId);

            return $user->can('update', $requested);
        }
        if(count($this->route()->parameters) > 0){
            $requestedId = (int)$this->route()->parameters['booking'];
            $requested = Booking::find($requestedId);

            return $user->can('view', $requested);
        }

//        return $user->can('viewAny', Booking::class);
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        if($this->method() === 'POST'){
            return [
                'concern_type' => 'nullable|string',
                'date'         => 'nullable|date',
                'time'         => 'nullable',
                'vehicle_id'   => 'nullable|numeric'
            ];
        }
        return [];
    }
}
