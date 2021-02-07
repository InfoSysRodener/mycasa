<?php

namespace App\Http\Requests;

use App\Models\Vehicle;
use App\Http\Requests\AbstractRequest as FormRequest;
use Illuminate\Support\Facades\Auth;

class VehicleRequest extends FormRequest
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
            return $user->can('create', Vehicle::class);
        }

        if($this->method() === 'PUT'){

            $requestedId = (int)$this->route()->parameters['vehicle'];
            $requested = Vehicle::find($requestedId);

            return $user->can('update', $requested);
        }

        if($this->method() === 'DELETE')
        {
            return $user->can('delete', Vehicle::class);
        }

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
                //
                'make'      => 'required|string',
                'model'     => 'required|string',
                'year'      => 'required|string',
                'variant'   => 'required|string',
                'mileage'   => 'nullable|string',
                'fuel'      => 'nullable|string',
                'plate_no'  => 'nullable|string',
                'engine_code'   => 'nullable|string',
                'chassis_code'  => 'nullable|string',
                'app_id_number' => 'nullable|string',
            ];
        }
        return [

        ];
    }
}
