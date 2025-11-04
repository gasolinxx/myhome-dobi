<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ScheduleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('schedules')->insert([
            [
                'staff_id' => 2,
                'category' => 'bg-success',
                'start_time' => '2024-12-16 09:00:00',
                'end_time' => '2024-12-16 18:00:00',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'staff_id' => 4,
                'category' => 'bg-primary',
                'start_time' => '2024-12-16 09:00:00',
                'end_time' => '2024-12-16 18:00:00',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'staff_id' => 6,
                'category' => 'bg-info',
                'start_time' => '2024-12-16 09:00:00',
                'end_time' => '2024-12-16 18:00:00',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'staff_id' => 8,
                'category' => 'bg-dark',
                'start_time' => '2024-12-16 09:00:00',
                'end_time' => '2024-12-16 18:00:00',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'staff_id' => 10,
                'category' => 'bg-warning',
                'start_time' => '2024-12-16 09:00:00',
                'end_time' => '2024-12-16 18:00:00',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'staff_id' => 5,
                'category' => 'bg-primary',
                'start_time' => '2024-12-16 09:00:00',
                'end_time' => '2024-12-16 18:00:00',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            //2nd day
            [
                'staff_id' => 2,
                'category' => 'bg-success',
                'start_time' => '2024-12-17 09:00:00',
                'end_time' => '2024-12-17 18:00:00',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'staff_id' => 5,
                'category' => 'bg-primary',
                'start_time' => '2024-12-17 09:00:00',
                'end_time' => '2024-12-17 18:00:00',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'staff_id' => 10,
                'category' => 'bg-warning',
                'start_time' => '2024-12-17 09:00:00',
                'end_time' => '2024-12-17 18:00:00',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'staff_id' => 6,
                'category' => 'bg-info',
                'start_time' => '2024-12-17 09:00:00',
                'end_time' => '2024-12-17 18:00:00',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'staff_id' => 8,
                'category' => 'bg-dark',
                'start_time' => '2024-12-17 09:00:00',
                'end_time' => '2024-12-17 18:00:00',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            //3rd day
            [
                'staff_id' => 2,
                'category' => 'bg-success',
                'start_time' => '2024-12-18 09:00:00',
                'end_time' => '2024-12-18 18:00:00',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'staff_id' => 4,
                'category' => 'bg-primary',
                'start_time' => '2024-12-18 09:00:00',
                'end_time' => '2024-12-18 18:00:00',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'staff_id' => 6,
                'category' => 'bg-info',
                'start_time' => '2024-12-18 09:00:00',
                'end_time' => '2024-12-18 18:00:00',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'staff_id' => 8,
                'category' => 'bg-dark',
                'start_time' => '2024-12-18 09:00:00',
                'end_time' => '2024-12-18 18:00:00',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'staff_id' => 10,
                'category' => 'bg-warning',
                'start_time' => '2024-12-18 09:00:00',
                'end_time' => '2024-12-18 18:00:00',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'staff_id' => 5,
                'category' => 'bg-primary',
                'start_time' => '2024-12-18 09:00:00',
                'end_time' => '2024-12-18 18:00:00',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            //4th day
            [
                'staff_id' => 2,
                'category' => 'bg-success',
                'start_time' => '2024-12-19 09:00:00',
                'end_time' => '2024-12-19 18:00:00',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'staff_id' => 4,
                'category' => 'bg-primary',
                'start_time' => '2024-12-19 09:00:00',
                'end_time' => '2024-12-19 18:00:00',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'staff_id' => 6,
                'category' => 'bg-info',
                'start_time' => '2024-12-19 09:00:00',
                'end_time' => '2024-12-19 18:00:00',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'staff_id' => 8,
                'category' => 'bg-dark',
                'start_time' => '2024-12-19 09:00:00',
                'end_time' => '2024-12-19 18:00:00',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'staff_id' => 10,
                'category' => 'bg-warning',
                'start_time' => '2024-12-19 09:00:00',
                'end_time' => '2024-12-19 18:00:00',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'staff_id' => 5,
                'category' => 'bg-primary',
                'start_time' => '2024-12-19 09:00:00',
                'end_time' => '2024-12-19 18:00:00',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            //5th day
            [
                'staff_id' => 2,
                'category' => 'bg-success',
                'start_time' => '2024-12-20 09:00:00',
                'end_time' => '2024-12-20 18:00:00',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'staff_id' => 4,
                'category' => 'bg-primary',
                'start_time' => '2024-12-20 09:00:00',
                'end_time' => '2024-12-20 18:00:00',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'staff_id' => 6,
                'category' => 'bg-info',
                'start_time' => '2024-12-20 09:00:00',
                'end_time' => '2024-12-20 18:00:00',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'staff_id' => 8,
                'category' => 'bg-dark',
                'start_time' => '2024-12-20 09:00:00',
                'end_time' => '2024-12-20 18:00:00',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'staff_id' => 10,
                'category' => 'bg-warning',
                'start_time' => '2024-12-20 09:00:00',
                'end_time' => '2024-12-20 18:00:00',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'staff_id' => 5,
                'category' => 'bg-primary',
                'start_time' => '2024-12-20 09:00:00',
                'end_time' => '2024-12-20 18:00:00',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
