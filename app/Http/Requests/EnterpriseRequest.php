<?php

namespace App\Http\Requests;

use App\Http\Requests\AbstractRequest as FormRequest;
use App\Models\Enterprise;
use Illuminate\Support\Facades\Auth;

class EnterpriseRequest extends FormRequest
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
            return $user->can('create', Enterprise::class);
        }

        if($this->method() === 'PUT'){
            return $user->can('update', Enterprise::class);
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
                'prefix'         => 'required|string|max:5',
                'name'           => 'required|string',
                'contact_person' => 'nullable|string'
            ];
        }
        return [];
    }
}
