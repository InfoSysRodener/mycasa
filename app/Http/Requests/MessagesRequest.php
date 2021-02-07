<?php

namespace App\Http\Requests;

use App\Models\Message;
use App\Http\Requests\AbstractRequest as FormRequest;
use Illuminate\Support\Facades\Auth;

class MessagesRequest extends FormRequest
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
            return $user->can('create', Message::class);
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
                'thread_id'     => 'required|string',
                'chat'          => 'nullable|string',
                'image'         => 'nullable|file',
                'is_read'       => 'nullable|string',
                'booking_id'    => 'nullable|numeric',
                'joborder_id'   => 'nullable|numeric',
            ];
        }
        return [];
    }
}