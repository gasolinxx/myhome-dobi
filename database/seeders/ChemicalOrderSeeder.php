<?php

namespace Database\Seeders;

use App\Models\ChemicalOrder;
use Illuminate\Database\Seeder;

class ChemicalOrderSeeder extends Seeder
{
    public function run()
    {
        ChemicalOrder::create([
            'details' => 'Detergent',
            'supplier_name' => 'SM Import and Export SDN. BHD.',
            'quantity' => 46,
        ]);

        ChemicalOrder::create([
            'details' => 'Bleach',
            'supplier_name' => 'Pakshoo Industrial Group',
            'quantity' => 20,
        ]);
    }
}
