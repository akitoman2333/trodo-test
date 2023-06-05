<?php

namespace App\API\V1\Requests\User;

use App\Models\Field;
use App\Models\User;
use App\API\V1\Requests\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class UpdateUser extends FormRequest
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
            'email' => ['required','email:rfc,dns','unique:users,email,'.$this->id],
            'name' => ['required', 'string','min:1', 'max:255'],
            'password' => ['nullable', Password::min(8)],
            'state' => ['nullable', Rule::in([
                User::STATE_UNCONFIRMED,
                User::STATE_BOUNCED,
                User::STATE_UNSUBSCRIBED,
                User::STATE_JUNK,
                User::STATE_ACTIVE
            ])],
            'role' => ['nullable', Rule::in([
                User::ROLE_ADMIN,
                User::ROLE_SUBSCRIBE
            ])],
            'fields' => ['nullable', 'array', 'min:1'],
            'fields.*' => ['required_with:fields', 'exists:fields,id']
        ];
    }

    /**
     * @return array
     */
    public function attributes()
    {
        return [
            'name' => 'Name',
            'email' => 'Email',
            'state' => 'State',
            'role' => 'Role',
            'password' => 'Password',
            'fields' => 'Fields',
            'fields.*' => 'Field',
        ];
    }

}
