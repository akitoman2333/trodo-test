<?php

namespace App\API\V1\Requests\Auth;

use App\API\V1\Requests\FormRequest;

class LoginUser extends FormRequest
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

    public function rules()
    {
        return [
            'email' => ['required', 'email:rfc,dns'],
            'password' => ['required', 'string','min:1', 'max:120'],
        ];
    }

    /**
     * @return array
     */
    public function attributes()
    {
        return [
            'email' => 'Email',
            'password' => 'Password'
        ];
    }
}
