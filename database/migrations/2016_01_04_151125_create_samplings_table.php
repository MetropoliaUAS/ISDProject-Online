<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSamplingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('samplings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer("sensor_id")->unsigned();
            $table->foreign("sensor_id")->references("id")->on("sensors");
            $table->float("sampled", 12, 4);
            $table->timestamp("created_at")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('samplings');
    }
}
