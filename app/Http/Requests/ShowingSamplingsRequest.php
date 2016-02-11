<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\JsonResponse;

class ShowingSamplingsRequest extends Request
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
            'date' => 'date',
            'end'   => 'date',
            'start' => 'date|required_with:end',
            'limit' => 'integer',
            'generic_sensor_id' => 'exists:generic_sensors,id'
        ];
    }


}
