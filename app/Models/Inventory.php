<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    use HasFactory;

    protected $fillable = [
        'inventory_number',  // Unique identifier for chemicals
        'name',              // Name of the chemical
        'details',           // Additional information about the chemical
        'current_stock',     // Current stock quantity
        'max_stock',         // Maximum stock capacity
        'unit',              // Measurement unit (e.g., liters, kg)
        'status',            // Status: 'Available', 'Low', or 'Out of Stock'
    ];

    // Define relationships (if needed)
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    // Accessor to calculate stock status dynamically
    public function getStockStatusAttribute()
    {
        $percentage = ($this->current_stock / $this->max_stock) * 100;

        if ($percentage > 60) {
            return 'Available';
        } elseif ($percentage > 20) {
            return 'Low';
        } else {
            return 'Out of Stock';
        }
    }

    public function chemicalOrders()
{
    return $this->hasMany(ChemicalOrder::class, 'inventory_id');
}

}
