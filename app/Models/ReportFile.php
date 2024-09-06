<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReportFile extends Model
{
    protected $fillable = [
        'doctor_name',
        'report_date',
        'file_path',
        'patient_id',
    ];


    protected $casts = [
        'report_date' => 'datetime',
    ];
    
    public function patient()
    {
        return $this->belongsTo(User::class, 'patient_id');
    }
}

