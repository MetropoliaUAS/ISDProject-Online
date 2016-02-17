<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\JsonResponse;

/**
 * App\Http\Requests\ProductCreationRequest
 *
 * @property string $id
 * @property string $version
 * @property array $sensors
 */
class ProductCreationRequest extends Request
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
            'id' => 'required|unique:products|regex:/^([0-9a-fA-F]{12})$/',
            'version' => 'required|max:255',
            'sensors' => 'required|array|exists:generic_sensors,id'
        ];
    }

    public function response(array $errors)
    {
        if ($this->ajax()) return new JsonResponse($errors, 422);

        return parent::response($errors);
    }


}
