<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name', 'description', 'expDate', 'price','batch', 'image', 'publisher','stock','appDate'
    ];

    
}
