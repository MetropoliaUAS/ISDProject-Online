<?php

use Illuminate\Database\Seeder;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $allGenericSensors = App\GenericSensor::all("id");

        factory(App\Product::class, 5)->create()->each(function (App\Product $newProduct) use ($allGenericSensors) {
            $newSensorsForEachGeneric = array();
            foreach ($allGenericSensors as $genericSensor) {
                $newSensorsForEachGeneric[] = new App\Sensor([
                    'generic_sensor_id' => $genericSensor->getKey()
                ]);
            }
            $newProduct->sensors()->saveMany($newSensorsForEachGeneric);
        });
    }
}
