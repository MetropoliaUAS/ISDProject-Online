<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/


//Creates location and user at the same time to get foreign user id
$factory->define(App\Location::class, function (Faker\Generator $faker) use ($factory)  {
    return [
        'address' => $faker->streetAddress,
		'zip' => $faker->postcode,
        'city' => $faker->city,
        'country_code' => $faker->countryCode,
		'user_id' => $factory->create(App\User::class)->id, 
		'product_id' => $factory->create(App\Product::class)->id,		
    ];
});

$factory->define(App\User::class, function (Faker\Generator $faker) {
    return [
        'first_name' => $faker->firstName,
		'last_name' => $faker->lastName,
        'email' => $faker->email,
        'password' => Hash::make(str_random(10)),
        'remember_token' => str_random(10),
    ];
});



//Samplings->Sensor->products

//Creates samplings and create sensors to store directly the foreign sensor id
$factory->define(App\Sampling::class, function (Faker\Generator $faker) use ($factory){
    return [
        'sensor_id' => $factory->create(App\Sensor::class)->id,  
		'sampled' => $faker->numberBetween($min = 0, $max = 50),
		'created_at' => $faker->dateTimeBetween($startDate = '-1 years', $endDate = 'now'),
    ];
});

//Creates Sensor and directly a product to get foreign product id
$factory->define(App\Sensor::class, function (Faker\Generator $faker) use ($factory){
    return [
       'generic_sensor_id' => $faker->numberBetween($min = 1, $max = 9), //one of the 10 sensors
	   'product_id' => $factory->create(App\Product::class)->id, 
    ];
});

$factory->define(App\Product::class, function (Faker\Generator $faker) {
    return [
		"id" => str_replace(":", "", $faker->macAddress),
        'version' => 'v1.0.0.0',
    ];
});

$factory->defineAS(App\Sampling::class, 'onlySamplings', function (Faker\Generator $faker) {
    return [
        'sensor_id' => $faker->numberBetween($min = 1, $max = 5),   
		'sampled' => $faker->numberBetween($min = 100, $max = 1000),
		'created_at' => $faker->dateTimeBetween($startDate = '-1 days', $endDate = 'now'),
    ];
});



