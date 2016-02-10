<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
	 
		
	 
    public function run()
    {
        Model::unguard();
		
		//STATIC Create needed sensor types
        $this->call(GenericSensorTableSeeder::class);

        // sorry bro :P
        $this->call(ProductsTableSeeder::class);
        $this->call(SamplingsTableSeeder::class);

        //Create 10 User entries for testing with help function and ModelFactory
        factory(App\Sampling::class, 10)->create(); //Samplings->Sensor->products

        //Creates 1000 Sampling entries for the sensors with id 1-5
        factory(App\Sampling::class, 'onlySamplings', 1000)->create();

        factory(App\Location::class, 10)->create(); //Location->User

        Model::reguard();
    }
}
