<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Delivery extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'pickup_id',
        'deliver_id',
        // 'pickup_driver',
        'proof_pickup',
        'delivery_date',
        // 'deliver_driver',
        'proof_deliver',

    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function pickupDriver()
    {
        return $this->belongsTo(User::class, 'pickup_id'); // Adjust 'pickup_id' to the foreign key in Delivery table
    }

    // In Delivery.php model
    public function deliveryDriver()
    {
        return $this->belongsTo(User::class, 'deliver_id'); // Assuming 'deliver_id' is the foreign key
    }
}
