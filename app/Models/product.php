<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name', 'description', 'expDate', 'price', 'image', 'publisher',
    ];

    // 其他模型代码...
}
