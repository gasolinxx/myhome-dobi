<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StaffSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        DB::table('staff')->insert([
            [
                'user_id' => 3,
                'gender' => 'Male',
                'role' => 'Manager',
                'address' => '12, Kampung Pekan Lama',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 4,
                'gender' => 'Male',
                'role' => 'Dry Cleaner',
                'address' => '34, Kampung Pekan Baru',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 5,
                'gender' => 'Female',
                'role' => 'Dry Cleaner',
                'address' => 'Lot 23, Kampung Makmur',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'user_id' => 6,  
                'gender' => 'Male',
                'role' => 'Pickup & Delivery Driver',
                'address' => '12, Lorong 8 Beruas Jaya',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 7,  
                'gender' => 'Male',
                'role' => 'Pickup & Delivery Driver',
                'address' => '20, Jalan Tangkas',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 8,  
                'gender' => 'Female',
                'role' => 'Washer/Folder',
                'address' => '7, Lorong 10 Beruas Jaya',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 9,  
                'gender' => 'Female',
                'role' => 'Washer/Folder',
                'address' => 'No. 25, Jalan Rama-Rama',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 10,  
                'gender' => 'Female',
                'role' => 'Presser/Ironing',
                'address' => '43, Taman Peramu Jaya',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 11,  
                'gender' => 'Female',
                'role' => 'Presser/Ironing',
                'address' => '43, Taman Peramu Jaya',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 12,  
                'gender' => 'Male',
                'role' => 'Dryer',
                'address' => '7, Lorong 10 Beruas Jaya',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 13,  
                'gender' => 'Female',
                'role' => 'Dryer',
                'address' => '43, Taman Peramu Jaya',
                'created_at' => now(),
                'updated_at' => now(),
            ],
           
        ]);
    }
}
