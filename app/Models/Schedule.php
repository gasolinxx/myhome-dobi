<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'staff_id', 
        'category', 
        'start_time', 
        'end_time'
    ];

    public function staff()
    {
        return $this->belongsTo(Staff::class);
    }
}
