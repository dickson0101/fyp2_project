<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class doctor extends Model
{
    protected $fillable = [
        'name',
        'image',
        'certificate',
        'specialist',
        'telephone',
        'language',
        'consultation_date',
        'consultation_time',
    ];
    
}
