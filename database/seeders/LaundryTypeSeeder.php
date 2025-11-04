<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LaundryTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('laundry_types')->insert([

            [
                'laundry_name' => 'Clothes',
                'description' => 'Regular wear, formal wear, uniforms, sportswear',
            ],

            [
                'laundry_name' => 'Curtains',
                'description' => 'Sheer curtains, blackout curtains, heavy drapes.',
            ],

            [
                'laundry_name' => 'Specialty Items',
                'description' => 'Wedding gowns, suits, costumes.',
            ],

        ]);
    }
}
