<?php

use Illuminate\Database\Seeder;

class OrdersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i <= 50; $i++) {
            \App\Order::create([
                'customer_id' => 12,
                'city' => 'Lahore',
                'street_id' => 3,
                'delivery_time' => '12 : 12',
                'customer_name' => 'Mubashar',
                'status' => 0,
                'comment' => 'Bulk Orders'
            ]);
        }

    }
}
