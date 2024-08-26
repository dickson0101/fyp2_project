<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    protected $fillable = [
        'name', 'image', 'certificate', 'specialist', 'telephone', 'language', 'dates_and_times'
    ];

    protected $casts = [
        'dates_and_times' => 'array', // 将 JSON 数据转化为数组
        
    ];
}
