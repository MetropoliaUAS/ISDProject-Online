<?php

namespace App\Http\Controllers;

use App\Product;
use App\Sensor;

use App\Http\Requests\ProductCreationRequest;

class ProductsController extends Controller
{

    public function store(ProductCreationRequest $request) {
        $newProduct = Product::create([
            'id' => $request->id,
            'version' => $request->version
        ]);

        foreach ($request->sensors as $generic_sensor_id)
        {
            $newProduct->sensors()->save(
                new Sensor([
                    'generic_sensor_id' => $generic_sensor_id
                ])
            );
        }

        return $newProduct;
    }
}
