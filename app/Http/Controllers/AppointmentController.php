<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Models\Appointment;

class AppointmentController extends Controller
{

    public function add(Request $request)
{


    Appointment::create([
        'speciality' => $request->specialitys,
        'timeSlot' => $request->timeSlots,
        'appointmentType' => $request->appointmentTypes,
        'appointmentDate' => $request->appointmentDates,
        
        'doctor' => $request->doctors,
    ]);

    return view('appointment');
}

    public function view()
    {
        return view('appointment');
    }
    public function view2()
    {
        return view('checkAppointment');
    }

    public function view3()
    {
        return view('successAppointment');
    }

    public function view4()
    {
        return view('nursePage2');
    }

}
