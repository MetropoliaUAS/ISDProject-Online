<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class SamplingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $allNewSamplings = array();

        $faker = App::make(Faker\Generator::class);

        $humiditySensors = App\GenericSensor::with("sensors")->where("alias", "Humidity")->first()->sensors;
        $temperatureSensors = App\GenericSensor::with("sensors")->where("alias", "Temperature")->first()->sensors;

        $everyDate = array();
        $timeThreshold = 10; // minutes
        $numberOfDays = 2;
        $numberOfLoop = 24 * 60 / $timeThreshold;

        $samplingTime = Carbon::now();

        foreach (range(0, $numberOfDays - 1) as $day) {
            foreach (range(0, $numberOfLoop - 1) as $time) {
                array_push(
                    $everyDate,
                    $samplingTime->copy()
                );
                $samplingTime->subMinutes($timeThreshold);
            }
        }

        foreach ($humiditySensors as $humiditySensor) {
            foreach ($everyDate as $samplingDate) {
                array_push(
                    $allNewSamplings,
                    array(
                        'sensor_id'  => $humiditySensor->getKey(),
                        'sampled'    => $faker->randomFloat(2, 20, 60),
                        'created_at' => $samplingDate
                    )
                );
            }
        }

        foreach ($temperatureSensors as $temperatureSensor) {
            foreach ($everyDate as $samplingDate) {
                array_push(
                    $allNewSamplings,
                    array(
                        'sensor_id'  => $temperatureSensor->getKey(),
                        'sampled'    => $faker->randomFloat(2, 19, 24),
                        'created_at' => $samplingDate
                    )
                );
            }
        }

        DB::table('samplings')->insert($allNewSamplings);
    }
}
