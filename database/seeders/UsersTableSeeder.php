<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            //admin
            [
                'name' =>  'Admin 1',
                'contact_number' =>  '0123456789',
                'role' => 'Admin',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('password'),
                'created_at' => now(),
                'updated_at' => now(),
            ],

            //customer
            [
                'name' =>  'Siti Fatimah',
                'contact_number' =>  '0123456789',
                'role' => 'Customer',
                'email' => 'customer@gmail.com',
                'password' => Hash::make('password'),
                'created_at' => now(),
                'updated_at' => now(),
            ],

            //staff
            [
                'name' =>  'Kamal Afli', 
                'contact_number' =>  '0123456789',
                'role' => 'Staff',
                'email' => 'staff@gmail.com',
                'password' => Hash::make('password'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' =>  'Mohd Amri', 
                'contact_number' =>  '0123456549',
                'role' => 'Staff',
                'email' => 'amri@gmail.com',
                'password' => Hash::make('password'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' =>  'Siti Jamilah', 
                'contact_number' =>  '0134567990',
                'role' => 'Staff',
                'email' => 'jamilah@gmail.com',
                'password' => Hash::make('password'),
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'name' => 'Khairul Aming',
                'contact_number' => '0109865123',
                'role' => 'Staff',
                'email' => 'khairul.aming@gmail.com',
                'password' => Hash::make('password'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Ahmad Abdul',
                'contact_number' => '0125674887',
                'role' => 'Staff',
                'email' => 'ahmad@gmail.com',
                'password' => Hash::make('password'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
          
            [
                'name' => 'Nik Adilah',
                'contact_number' => '0145432172',
                'role' => 'Staff',
                'email' => 'nik.dillah@gmail.com',
                'password' => Hash::make('password'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Nurul Wahidah',
                'contact_number' => '0198765211',
                'role' => 'Staff',
                'email' => 'wahidah@gmail.com',
                'password' => Hash::make('password'),
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'name' => 'Sofea Allysa',
                'contact_number' => '0109865432',
                'role' => 'Staff',
                'email' => 'sofea66@gmail.com',
                'password' => Hash::make('password'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Mariam Melissa',
                'contact_number' => '0124532786',
                'role' => 'Staff',
                'email' => 'mariam@gmail.com',
                'password' => Hash::make('password'),
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'name' => 'Mohd Razak',
                'contact_number' => '0145432231',
                'role' => 'Staff',
                'email' => 'razak@gmail.com',
                'password' => Hash::make('password'),
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'name' => 'Nur Aminah',
                'contact_number' => '0109876321',
                'role' => 'Staff',
                'email' => 'amninah@gmail.com',
                'password' => Hash::make('password'),
                'created_at' => now(),
                'updated_at' => now(),
            ],

             //customer 2
             [
                'name' =>  'Ahmad Nazran',
                'contact_number' =>  '0196007076',
                'role' => 'Customer',
                'email' => 'nazran@gmail.com',
                'password' => Hash::make('password'),
                'created_at' => now(),
                'updated_at' => now(),
            ],

            //customer 3
            [
                'name' =>  'Alisa Asyra',
                'contact_number' =>  '0189457890',
                'role' => 'Customer',
                'email' => 'alisa@gmail.com',
                'password' => Hash::make('password'),
                'created_at' => now(),
                'updated_at' => now(),
            ],

            //customer 4
            [
                'name' =>  'Ali Suffian',
                'contact_number' =>  '0164532574',
                'role' => 'Customer',
                'email' => 'suffian@gmail.com',
                'password' => Hash::make('password'),
                'created_at' => now(),
                'updated_at' => now(),
            ],

            //customer 5
            [
                'name' =>  'Suraya Kamal',
                'contact_number' =>  '0132023041',
                'role' => 'Customer',
                'email' => 'suraya@gmail.com',
                'password' => Hash::make('password'),
                'created_at' => now(),
                'updated_at' => now(),
            ],

            
        ]);
    }
}
