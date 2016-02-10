<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGenericSensorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('generic_sensors', function (Blueprint $table) {
            $table->increments('id');
            $table->string("alias", 60); //e.g.: Temperature, Acceleration, Humidity
            $table->string("name");
            $table->string("symbol", 10);
            $table->string("unit", 10);
            $table->string("range", 60);
            $table->string("producer");
            $table->nullableTimestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('generic_sensors');
    }
}
