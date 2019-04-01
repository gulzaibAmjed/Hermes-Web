<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStreetsNeighbourhoodAndCitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('streets_neighbourhood_and_cities', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->integer('parent_id')->nullable()->unsigned();
            $table->foreign('parent_id')->references('id')->on('streets_neighbourhood_and_cities')->onDelete('cascade');
            $table->integer('grand_parent_id')->nullable()->unsigned();
            $table->foreign('grand_parent_id')->references('id')->on('streets_neighbourhood_and_cities')->onDelete('cascade');
            $table->string('name', 50);
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
        Schema::drop('streets_neighbourhood_and_cities');
    }
}
