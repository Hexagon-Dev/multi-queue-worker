<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserCreateRequest extends FormRequest
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
            'name' => 'string|required',
            'email' => 'string|required',
            'email_verified_at' => 'string|required',
            'password' => 'string|required',
            'remember_token' => 'string|required',
            'login' => 'string|required',
            'color' => 'string',
            'food' => 'string',
        ];
    }
}
