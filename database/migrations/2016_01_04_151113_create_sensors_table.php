<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSensorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sensors', function (Blueprint $table) {
            $table->increments('id');
            $table->integer("generic_sensor_id")->unsigned();
            $table->foreign("generic_sensor_id")->references("id")->on("generic_sensors");
            // Every bubble will be configured with a unique "product id", that the user
            // will register
            $table->string("product_id");
            $table->foreign("product_id")->references("id")->on("products");
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
        Schema::drop('sensors');
    }
}
