<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChemicalOrder extends Model
{
    use HasFactory;

    protected $table = 'chemical_orders';

    // Fields that can be mass-assigned
    protected $fillable = [
        'details',
        'supplier_name',
        'quantity',
    ];

    public function inventory()
{
    return $this->belongsTo(Inventory::class, 'inventory_id');
}

}
