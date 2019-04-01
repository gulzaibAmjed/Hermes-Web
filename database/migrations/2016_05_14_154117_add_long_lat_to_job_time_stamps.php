<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddLongLatToJobTimeStamps extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('job_time_stamps', function (Blueprint $table) {
            $table->double('longitude',9,6)->default(000.000000)->after('status');
            $table->double('latitude',9,6)->default(000.000000)->after('longitude');
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
