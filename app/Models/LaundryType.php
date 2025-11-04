<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaundryType extends Model
{
    use HasFactory;

    protected $fillable = ['laundry_name', 'description'];

    public function services()
    {
        return $this->hasMany(LaundryService::class);
    }
}
