<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
class RegisterRequest extends FormRequest
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
        return [
            'name'  =>  'required',
            'phone' =>  'required|unique:users,phone_number',
            'email' =>  'required|unique:users,email',
            'password'  =>  'required|confirmed|min:6',
            'type'      =>  'required|in:individual,entity'
        ];
    }

    public function messages()
    {
        return [
            'type.in'   =>  'Entity or individual',
            'email.unique'  =>  'Логин существует',
            'phone.unique'  =>  'Номер существует',
        ];
    }
}
