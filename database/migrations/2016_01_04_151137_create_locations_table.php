<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLocationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('locations', function (Blueprint $table) {
            $table->increments('id');
            $table->string("address", 100);
            $table->string("zip", 10);
            $table->string("city", 100);
            $table->string("country_code", 2);
            $table->integer("user_id")->unsigned();
            $table->foreign("user_id")->references("id")->on("users");
            // we create this "link" ourselves
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
        Schema::drop('locations');
    }
}
