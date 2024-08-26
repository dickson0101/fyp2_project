<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\DoctorSchedule;

class AppointmentController extends Controller
{
    public function getDoctorUnavailableTimes($doctorId, Request $request)
{
    $date = $request->input('date');
    $doctor = Doctor::find($doctorId);
    $unavailableTimes = [];
    $appointmentTimes = [];

    if ($doctor) {
        // 获取医生的时间安排
        $datesAndTimes = $doctor->dates_and_times; // 获取医生的时间安排
        if (is_string($datesAndTimes)) {
            $datesAndTimes = json_decode($datesAndTimes, true);
        }

        foreach ($datesAndTimes as $entry) {
            if ($entry['date'] === $date) {
                $unavailableTimes = array_merge($unavailableTimes, $entry['timeSlots']);
            }
        }
        $unavailableTimes = array_unique($unavailableTimes);
    }

    // 获取预约表中的时间槽
    $appointments = Appointment::where('doctor_id', $doctorId)
                               ->where('appointment_date', $date)
                               ->get();

    foreach ($appointments as $appointment) {
        $timeSlots = $appointment->time_slot; // 获取时间槽
        if (is_string($timeSlots)) {
            $timeSlots = json_decode($timeSlots, true);
        }
        if ($timeSlots) {
            $appointmentTimes = array_merge($appointmentTimes, $timeSlots);
        }
    }

    $appointmentTimes = array_unique($appointmentTimes);

    return response()->json([
        'unavailableTimes' => $unavailableTimes,
        'appointmentTimes' => $appointmentTimes
    ]);
}

    
public function add(Request $request)
{
    // Ensure you are using the correct field name 'selectedTimeSlot'
    $timeSlots = $request->input('selectedTimeSlot');
    
    // Check if $timeSlots is being correctly decoded from JSON
    $timeSlotsJson = $timeSlots ? json_decode($timeSlots, true) : null;

    $appointment = new Appointment();
    $appointment->doctor_id = $request->input('doctor_id');
    $appointment->appointment_date = $request->input('appointmentDate');
    $appointment->appointment_type = $request->input('appointment-type');
    $appointment->time_slot = $timeSlotsJson;
    $appointment->save();

    $doctors = Doctor::all();
    return view('appointment', ['doctors' => $doctors]);
}

    public function view()
    {
        return view('doctorPage');
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
    $appointments = Appointment::all();
    return view('nursePage2', ['appointments' => $appointments]);
}

}
