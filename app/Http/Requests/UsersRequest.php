<?php

namespace App\Http\Requests;

use App\Http\Requests\AbstractRequest as FormRequest;
//use Illuminate\Foundation\Http\FormRequest;

class UsersRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        if($this->method() === 'POST')
        {
            return [
                'email'         => 'required|email|unique:users',
                'password'      => 'required',
                'mobile_number' => 'required|unique:users'
            ];
        }
        return [
            //
        ];
    }
}
