<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->integer('customer_id')->unsigned();
            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
            $table->integer('manager_id')->nullable()->unsigned();
            $table->foreign('manager_id')->references('id')->on('managers')->onDelete('cascade');
            $table->string('city', 60);
            $table->string('street', 255);
            $table->string('address', 255);
            $table->string('street_number', 60);
            $table->string('delivery_time', 30);
            $table->string('customer_name', 30)->nullable();
            $table->text('comments')->nullable();
            $table->tinyInteger('status');
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
        Schema::drop('orders');
    }
}
