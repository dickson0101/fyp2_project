<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    protected $fillable = [
        'name',
        'image',
        'certificate',
        'specialist',
        'telephone',
        'language',
        'dates_and_times',
    ];

    protected $casts = [
        'dates_and_times' => 'array', // Converts JSON in DB to array in PHP
    ];

    // Define the relationship to the Appointment model
    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }
}
