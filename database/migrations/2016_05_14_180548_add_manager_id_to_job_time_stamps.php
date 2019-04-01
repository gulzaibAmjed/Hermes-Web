<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddManagerIdToJobTimeStamps extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('job_time_stamps', function (Blueprint $table) {
            // $table->dropColumn('manager_id');
            $table->integer('manager_id')->unsigned()->nullable()->default(null);
            $table->foreign('manager_id')->references('id')->on('managers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('job_time_stamps', function (Blueprint $table) {
            //
        });
    }
}
