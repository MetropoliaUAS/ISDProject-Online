<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Illuminate\Http\JsonResponse;

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
            'product_id' => 'required|exists:products,id',
            'samplings' => 'required|array'
            //'samplings.*.generic_sensor_id' => 'integer', // no need for required rule, can't be applied
            //'samplings.*.value' => 'numeric' // no need for required rule, can't be applied
        ];
    }

    public function response(array $errors)
    {
        if ($this->ajax()) return new JsonResponse($errors, 422);

        return parent::response($errors);
    }

}
