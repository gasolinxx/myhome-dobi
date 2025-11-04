<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'user_id', 
        'guest_id', 
        'laundry_service_id', 
        'laundry_type_id',
        'remark',
        'quantity',
        'total_amount',
        'delivery_fee',
        'status',
        'order_method',
        'delivery_option',
        'address',
        'pickup_date',
    ];

    // Define relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function guest()
    {
        return $this->belongsTo(Guest::class);
    }

    public function laundryService()
    {
        return $this->belongsTo(LaundryService::class);
    }

    public function laundryType()
    {
        return $this->belongsTo(LaundryType::class);
    }

    public function delivery()
    {
        return $this->hasMany(Delivery::class);
    }
 

}
