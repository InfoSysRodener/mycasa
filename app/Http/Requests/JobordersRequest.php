<?php

namespace App\Http\Requests;

use App\Models\Joborder;
use App\Http\Requests\AbstractRequest as FormRequest;
use Illuminate\Support\Facades\Auth;

class JobordersRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $user = Auth::guard('api')->user();

        if($this->method() === 'POST')
        {
            return $user->can('create', Joborder::class);
        }
        if($this->method() === 'PUT')
        {
            $requestedId = (int)$this->route()->parameters['joborder'];
            $requested = Joborder::find($requestedId);

            return $user->can('update', $requested);
        }
        if(count($this->route()->parameters) > 0)
        {
            $requestedId = (int)$this->route()->parameters['joborder'];
            $requested = Joborder::find($requestedId);

            return $user->can('view', $requested);
        }

        return $user->can('viewAny', Joborder::class);
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
                'requested_at' => 'nullable|date',
                'completed_at' => 'nullable|date',
                'concern'      => 'nullable|string',
                'assessment'   => 'nullable|string',
                'solution'     => 'nullable|string',
                'user_id'      => 'required',
            ];
        }
        return [];
    }
}
