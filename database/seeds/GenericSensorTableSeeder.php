<?php

use Illuminate\Database\Seeder;

class GenericSensorTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Creates types of used sensors
        //For each measured value one entry

        App\GenericSensor::create([
            'name' => 'ADXL330 Analog Devices Accelerometer',
            'alias' => 'Accelerometer',
            'unit' => 'G',
        ]);

        App\GenericSensor::create([
            'name' => 'BME280 Bosch combined humidity and pressure sensor',
            'alias' => 'Humidity',
            'unit' => '',
        ]);

        App\GenericSensor::create([
            'name' => 'BME280 Bosch combined humidity and pressure sensor',
            'alias' => 'Pressure',
            'unit' => 'kPa',
        ]);

        App\GenericSensor::create([
            'name' => 'BME280 Bosch combined humidity and pressure sensor',
            'alias' => 'Temperature',
            'unit' => '°C',
        ]);

    }
}
