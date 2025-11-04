<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('orders')->insert([

            // For Registered User
            [
                'user_id' => 2, 
                'laundry_service_id' => 1, 
                'laundry_type_id' => 1, 
                'quantity' => null,
                'total_amount' => null,
                'status' => 'Pickup',
                'order_method' => 'Pickup',
                'delivery_option' => true,
                'delivery_fee' => null,
                'address' => 'No 63, Jalan Beringin, Taman Melodies',
                'remark' => null,
                'pickup_date' => now(),
                'created_at' => now(),
                'updated_at' => null,
            ],

            // For Registered User with Remark
            [
                'user_id' => 14, 
                'laundry_service_id' => 3, 
                'laundry_type_id' => 1, 
                'quantity' => 1,
                'total_amount' => 10,
                'status' => 'Assign Delivery',
                'order_method' => 'Pickup',
                'delivery_option' => true,
                'delivery_fee' => 5,
                'address' => 'No. 22B Jalan Pandan Indah 1/23A',
                'remark' => 'Tolong basuh elok-elok', 
                'pickup_date' => now(),
                'created_at' => now(),
                'updated_at' => null,
            ],

            // For Registered User with Remark
            [
                'user_id' => 16, 
                'laundry_service_id' => 1, 
                'laundry_type_id' => 1, 
                'quantity' => null,
                'total_amount' => null,
                'status' => 'Assign Pickup',
                'order_method' => 'Pickup',
                'delivery_option' => true,
                'delivery_fee' => null,
                'address' => ' PLOT 557 Lorong Perusahaan 4, Prai Free Trade Zone Phase 1',
                'remark' => 'Baju mudah koyak jadi sila basuh dengan cermat', 
                'pickup_date' => now(),
                'created_at' => now(),
                'updated_at' => null,
            ],

             // For Registered User
             [
                'user_id' => 17, 
                'laundry_service_id' => 3, 
                'laundry_type_id' => 1, 
                'quantity' => 5,
                'total_amount' => 28,
                'status' => 'In Work',
                'order_method' => 'Pickup',
                'delivery_fee' => 3,
                'delivery_option' => false,
                'address' => 'No 213, Jln Bandar 2 Taman Melawati Hulu',
                'remark' => null,
                'pickup_date' => now(),
                'created_at' => now(),
                'updated_at' => null,
            ],

             // For Registered User
             [
                'user_id' => 2, 
                'laundry_service_id' => 2, 
                'laundry_type_id' => 1, 
                'quantity' => 5,
                'total_amount' => 10,
                'status' => 'Pay',
                'order_method' => 'Walk in',
                'delivery_fee' => null,
                'delivery_option' => false,
                'address' => null,
                'remark' => null,
                'pickup_date' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],

             // For Registered User
             [
                'user_id' => 14, 
                'laundry_service_id' => 2, 
                'laundry_type_id' => 1, 
                'quantity' => 5,
                'total_amount' => 10,
                'status' => 'Complete',
                'order_method' => 'Walk in',
                'delivery_fee' => null,
                'delivery_option' => false,
                'address' => null,
                'remark' => null,
                'pickup_date' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],


        ]);
    }
}
