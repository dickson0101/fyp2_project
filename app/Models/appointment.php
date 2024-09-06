<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model 
{
    protected $fillable = [
        'doctor',
        'appointmentDate',
        'appointmentType',
        'timeSlot',
        'speciality',
        'patient_id',
        'doctor_id',
        'appointmentDT',
    ];

    // In Appointment model
public function patient()
{
    return $this->belongsTo(User::class, 'patient_id');
}


    public function doctor()
    {
        return $this->belongsTo(Doctor::class, 'doctor_id');
    }

    // If you need to access timeSlot as an array, you can use an accessor
    public function getTimeSlotArrayAttribute()
    {
        return json_decode($this->timeSlot, true) ?? [];
    }
}