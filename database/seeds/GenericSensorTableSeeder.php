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

        DB::table('generic_sensors')->insert([
			'alias' => 'Carbon-Dioxide',
			'name' => 'MD62',
			'symbol' => 'CO^2',
			'unit' => 'ppm',
			'range' => '0-40000',
			'producer' => 'Hanwei Electronics',
        ]);
		
		DB::table('generic_sensors')->insert([
			'alias' => 'Carbon-Monoxide',
			'name' => 'MQ7',
			'symbol' => 'CO',
			'unit' => 'ppm',
			'range' => '0-4000',
			'producer' => 'Hanwei Electronics',
        ]);
		
		DB::table('generic_sensors')->insert([
			'alias' => 'Volume',
			'name' => 'MAX4465',
			'symbol' => 'Vol',
			'unit' => 'dB',
			'range' => '0-120',
			'producer' => 'Challenge Electronics',
        ]);
		
		DB::table('generic_sensors')->insert([
			'alias' => 'Light intensity',
			'name' => 'TSL2561',
			'symbol' => 'Ev',
			'unit' => 'Lux',
			'range' => '0-2000',
			'producer' => 'TAOS',
        ]);
		
		DB::table('generic_sensors')->insert([
			'alias' => 'Acceleration',
			'name' => 'ADXL330',
			'symbol' => 'a',
			'unit' => 'g',
			'range' => '0-5',
			'producer' => 'Analog Devices',
        ]);
		
		DB::table('generic_sensors')->insert([
			'alias' => 'Temperature',
			'name' => 'BME280',
			'symbol' => 'T',
			'unit' => '°C',
			'range' => '0-80',
			'producer' => 'Bosch',
        ]);
		
		DB::table('generic_sensors')->insert([
			'alias' => 'Humidity',
			'name' => 'BME280',
			'symbol' => 'Hr',
			'unit' => '%',
			'range' => '0-100',
			'producer' => 'Bosch',
        ]);
		
		DB::table('generic_sensors')->insert([
			'alias' => 'Pressure',
			'name' => 'BME280',
			'symbol' => 'P',
			'unit' => '3hPa',
			'range' => '0-2200',
			'producer' => 'Bosch',
        ]);
		
		DB::table('generic_sensors')->insert([
			'alias' => 'Smoke',
			'name' => 'Optical',
			'symbol' => 'S',
			'unit' => '-',
			'range' => 'Binary',
			'producer' => '-',
        ]);
		
		DB::table('generic_sensors')->insert([
			'alias' => 'Buzzer',
			'name' => 'KEYES S',
			'symbol' => 'B',
			'unit' => '-',
			'range' => 'Binary',
			'producer' => '-',
        ]);
		
    }
}
