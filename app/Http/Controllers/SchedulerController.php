<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Models\Doctor;

class SchedulerController extends Controller
{
    public function index()
{
    $appointments = Appointment::all();
    $doctors = Doctor::all();

    return view('scheduler', compact('appointments', 'doctors'));
}

}
