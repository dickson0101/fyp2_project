<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class appointment extends Model
{
    protected $fillable = [
        'speciality', 'timeSlot', 'appointmentType', 'appointmentDate',"doctor"
    ];

    // 其他模型代码...
}