<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $casts = [
        'time_slot' => 'array',
    ];
    
    protected $fillable = [
        'doctor_id',
        'appointment_date',
        'appointment_type',
        'time_slot', // 确保与数据库字段一致
        'name',
    ];

    // If you're using created_at and updated_at columns
    public $timestamps = true;
}
