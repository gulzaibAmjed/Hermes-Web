<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStreetsAndCitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('streets_and_cities', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->integer('city_id')->nullable()->unsigned();
            $table->foreign('city_id')->references('id')->on('streets_and_cities')->onDelete('cascade');
            $table->string('name', 50);
            $table->integer('city_code')->nullable()->unsigned();
            $table->tinyInteger('type');
            $table->boolean('is_active');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('streets_and_cities');
    }
}
