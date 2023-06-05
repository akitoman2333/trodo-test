<?php

namespace App\API\V1\Requests\Auth;

use App\API\V1\Requests\FormRequest;
use Illuminate\Validation\Rules\Password;

class RegisterUser extends FormRequest
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
            'email' => ['required','email:rfc,dns','unique:users,email'],
            'name' => ['required', 'string','min:1', 'max:255'],
            'password' => ['required', Password::min(8)]
        ];
    }

    /**
     * @return array
     */
    public function attributes()
    {
        return [
            'email' => 'Email',
            'name' => 'Name',
            'password' => 'Password'
        ];
    }

}
