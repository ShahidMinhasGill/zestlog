<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AuthenticateRequest extends FormRequest
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
            'first_name' => 'required',
            'last_name' => 'required',
//            'user_name' => 'required|unique:users,user_name,{$id},id,deleted_at,NULL',
            'password' => 'required',
            'extension' => 'required',
            'mobile_number' => 'required|unique:users,mobile_number,{$id},id,deleted_at,NULL',
        ];
    }

    /**
     * Custom message for validation
     *
     * @return array
     */
    public function messages()
    {
        return [
            'display_name.required' => 'Display Name is required!',
            'user_name.required' => 'User Name is required!',
            'password.required' => 'Password is required!',
            'mobile_number.required' => 'Mobile Number is required!',
        ];
    }
    
}
