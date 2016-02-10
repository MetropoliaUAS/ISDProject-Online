<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class CreateSamplingsRequest extends Request
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
            'product_id' => 'required|size:12',
            'samplings' => 'required|array',
            'samplings.*.generic_sensor_id' => 'integer', // no need for required rule, can't be applied
            'samplings.*.value' => 'numeric' // no need for required rule, can't be applied
        ];
    }

}
