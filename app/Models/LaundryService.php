<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaundryService extends Model
{
    use HasFactory;

    protected $fillable = ['service_name', 'laundry_type_id', 'price'];

    public function laundryType()
    {
        return $this->belongsTo(LaundryType::class);
    }
}
