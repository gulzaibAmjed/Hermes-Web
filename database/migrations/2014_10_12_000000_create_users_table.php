<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->string('email', 60)->unique();
            $table->string('password', 60);
            $table->tinyInteger('role')->comment = "0 for admin 1 for customer and 2 for manager";
            $table->tinyInteger('is_confirmed')->comment = "0 for not and 1 for confirmed.";
            $table->string('confirmation_code', 30);
            $table->string('ip', 16)->nullable();
            $table->rememberToken();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('users');
    }
}
