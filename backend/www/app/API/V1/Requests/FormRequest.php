<?php

namespace App\API\V1\Requests;

use Illuminate\Foundation\Http\FormRequest as Base;
use App\API\V1\Traits\ApiResponseTrait;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Exceptions\HttpResponseException;

class FormRequest extends Base
{

    use ApiResponseTrait;

    /**
     * Force response json type when validation fails
     * @var bool
     */
    protected $forceJsonResponse = true;

    /**
     * Get the error messages for the defined validation rules.*
     * @return array
     */
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            $this->respondValidationErrors(new ValidationException($validator))
        );
    }
}
