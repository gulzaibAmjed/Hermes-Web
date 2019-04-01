<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Config;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'email' => 'admin@hermes.com',
            'password' => bcrypt('12345678'),
            'role' => Config::get('constants.USER_ROLE_ADMIN'),
            'is_confirmed' => 1,
        ]);
    }
}
