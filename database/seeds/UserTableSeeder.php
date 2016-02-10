<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Creates a dummy user for testing
        DB::table('users')->insert([
            'first_name' => "Elvis",
            'last_name' => "Presly",
            'email' => 'theking.@gmail.com',
            'password' => bcrypt('secret'),
            'remember_token' => str_random(10),
        ]);
    }
}
