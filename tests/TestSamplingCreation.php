<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class TestSamplingCreation extends TestCase
{
    /**
     * @var Faker\Generator
     */
    protected $faker;

    public function setUp()
    {
        parent::setUp();
        $this->faker = App::make('Faker\Generator');
    }


    /**
     * A basic test example.
     *
     * @return void
     */
    public function testSamplingCreationWithPost()
    {
        $product = App\Product::with('sensors')->get()->random();
        $generic_sensors = App\GenericSensor::all();
        $generic_sensor_with_random_function = array();

        foreach ($generic_sensors as $generic_sensor) {
            // Humidity, Pressure, Temperature
            switch ($generic_sensor->alias)
            {
                case "Humidity":
                    $generic_sensor_with_random_function[$generic_sensor->getKey()] = 'getRandomHumidityValue';
                    break;

                case "Temperature":
                    $generic_sensor_with_random_function[$generic_sensor->getKey()] = 'getRandomTemperatureValue';
                    break;

                case "Pressure":
                    $generic_sensor_with_random_function[$generic_sensor->getKey()] = 'getRandomPressureValue';
                    break;
            }
        }

        $newSamplings = array();

        foreach ($product->sensors as $sensor) {
            $gs_id = $sensor->generic_sensor_id;
            if ( ! array_has($generic_sensor_with_random_function, $gs_id)) continue;
            $sensor_random_value = call_user_func(array($this, $generic_sensor_with_random_function[$gs_id]));
            array_push(
                $newSamplings,
                array(
                    'generic_sensor_id' => $gs_id,
                    'value' => $sensor_random_value
                )
            );
        }

        $request_body = array(
            'product_id' => App\Product::all()->random()->getkey(),
            'samplings' => $newSamplings
        );
        $this->post('/samplings/create', $request_body)->see('Created ' . count($newSamplings) . ' sampling(s)');
    }

    public function getRandomHumidityValue () {
        return $this->faker->randomFloat(2, 40, 90);
    }

    public function getRandomTemperatureValue () {
        return $this->faker->randomFloat(2, -28, 42);
    }

    public function getRandomPressureValue () {
        return $this->faker->randomFloat(3, 105, 90);
    }
}
