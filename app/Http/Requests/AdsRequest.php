<?php

namespace App\Http\Requests;

use App\Http\Requests\AbstractRequest as FormRequest;
use App\Models\Ads;
use Illuminate\Support\Facades\Auth;

class AdsRequest extends FormRequest
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
            return $user->can('create', Ads::class);
        }

        if($this->method() === 'PUT'){

            $requestedId = (int)$this->route()->parameters['ads'];
            $requested = Ads::find($requestedId);

            return $user->can('update', $requested);
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
                'image' => 'required'
            ];
        }
        return [];
    }
}