<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Delivery;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $this->call(UsersTableSeeder::class);
        $this->call(LaundryTypeSeeder::class);
        $this->call(LaundryServiceSeeder::class);
        $this->call(OrderSeeder::class);
        $this->call(StaffSeeder::class);
        $this->call(ScheduleSeeder::class);
        $this->call(DeliverySeeder::class);
    }
}
