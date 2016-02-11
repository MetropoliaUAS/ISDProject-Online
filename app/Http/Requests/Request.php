<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Validation\ValidationException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

abstract class Request extends FormRequest
{
    protected function failedValidation(Validator $validator)
    {
        if (config('app.debug')) throw new ValidationException($validator);
        return parent::failedValidation($validator);
    }

}
