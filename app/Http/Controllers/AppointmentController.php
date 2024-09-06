<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Medication;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
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
        
        $datesAndTimes = $doctor->dates_and_times;
        if (is_string($datesAndTimes)) {
            $datesAndTimes = json_decode($datesAndTimes, true);
        }

       
        
        foreach ($datesAndTimes as $entry) {
            if ($entry['date'] === $date) {
                $unavailableTimes = array_merge($unavailableTimes, $entry['timeSlots']);
            }
        }
        $unavailableTimes = array_unique($unavailableTimes);

       
        $appointments = Appointment::where('doctor_id', $doctorId)
        ->whereDate('appointmentDate', $date)
        ->get();

foreach ($appointments as $appointment) {
$appointmentDT = $appointment->appointmentDT;

if (is_string($appointmentDT)) {
$appointmentDT = json_decode($appointmentDT, true);
}

foreach ($appointmentDT as $entry) {
if ($entry['date'] === $date) {
$appointmentTimes = array_merge($appointmentTimes, $entry['timeSlots']);
}
}
}

$appointmentTimes = array_unique($appointmentTimes);

return response()->json([
'unavailableTimes' => $unavailableTimes,
'appointmentTimes' => $appointmentTimes
]);

}

}

public function getDoctorAppointmentsTimes($doctorId, Request $request)
{
    $date = $request->input('date');
    $appointmentTimes = [];

   
    $appointments = Appointment::where('doctor_id', $doctorId)
                               
                               ->get();

    foreach ($appointments as $appointment) {
        $appointmentDT = $appointment->appointmentDT;

        if (is_string($appointmentDT)) {
            $appointmentDT = json_decode($appointmentDT, true);
        }

        foreach ($appointmentDT as $entry) {
            if ($entry['date'] === $date) {
                $appointmentTimes = array_merge($appointmentTimes, $entry['timeSlots']);
            }
        }
    }

    $appointmentTimes = array_unique($appointmentTimes);

    return response()->json([
        'appointmentTimes' => $appointmentTimes
    ]);
}




    public function add(Request $request)
    {
        
        $appointmentDTJson = $request->input('appointmentDT') ? json_decode($request->input('appointmentDT'), true) : null;
    
        
        if ($appointmentDTJson) {
            $doctorName = $request->input('doctorName'); // 确保请求中正确获取医生名字
    
            
            $doctor = User::where('name', $doctorName)->first();
    
            if ($doctor) {
                foreach ($appointmentDTJson as $entry) {
                   
                    $appointment = new Appointment();
                    $appointment->patient_id = Auth::id();
                    $appointment->doctor_id = $doctor->id;
                    $appointment->doctor = $doctorName;
                    $appointment->appointmentDate = $entry['date'];
                    $appointment->appointmentType = $request->input('appointmentType');
                    $appointment->timeSlot = json_encode($entry['timeSlots']); // 将时间槽编码为 JSON
                    $appointment->speciality = $request->input('specialitys');
                    $appointment->appointmentDT = json_encode($appointmentDTJson); // 存储整个 appointmentDT 数据
    
                    $appointment->save();
                }
    
                return redirect()->route('homePatient')->with('success', 'Appointments created successfully!');
            }
        }
    
        
        $doctors = Doctor::all();
        $appointments = Appointment::all();
                                   
                                   
        return view('appointment', compact('doctors', 'appointments'));
    }
    
    


    public function index2(){
        $appointments = Appointment::where('patient_id', Auth::id())
                                   ->orderBy('appointmentDate', 'asc')
                                   ->get();
        $doctors = Doctor::all();
        return view('appointmentPage', compact('appointments', 'doctors'));
    }
    


    public function index()
    {
        if (Auth::user()->role == 2) {
            
            $appointments = Appointment::where('patient_id', Auth::id())
                                       ->orderBy('appointmentDate', 'asc')
                                       ->get();
            return view('homePatient', ['appointments' => $appointments]);
        }}

    public function showDoctorDashboard()
    {
        
        $appointments = Appointment::where('doctor_id', Auth::id())
                                   ->orderBy('appointmentDate', 'asc')
                                   ->get();
        return view('homeDoctor', ['appointments' => $appointments]);
    }

    public function showNurseDashboard()
    {
        
        $appointments = Appointment::orderBy('appointmentDate', 'asc')
                                   ->get();
        return view('nursePage', ['appointments' => $appointments]);
    }
    
    

    public function edit($id)
    {
        $appointment = Appointment::findOrFail($id);
        $doctors = Doctor::all();
        $appointments = Appointment::all(); 
    
        return view('appointmentEdit', compact('appointment', 'doctors', 'appointments'));
    }
    
public function update(Request $request, $id)
{
    
    $appointment = Appointment::findOrFail($id);

    $doctorName = $request->input('doctorName'); 

    $doctor = User::where('name', $doctorName)->first();

   
    $timeSlots = $request->input('selectedTimeSlot'); 
    $timeSlotsJson = $timeSlots ? json_encode(json_decode($timeSlots)) : null;

    if ($doctor) {
    $appointment->doctor_id = $doctor->id;
    $appointment->speciality = $request->specialitys;
    $appointment->doctor = $request->doctorName;
    $appointment->appointmentDate = $request->appointmentDate;
    $appointment->timeSlot = $timeSlotsJson; 
    $appointment->appointmentType = $request->appointmentType;

    
    $appointment->save();

    
    return redirect()->route('appointmentPage')->with('success', 'Appointment updated successfully!');
}
}



public function delete($id)
{
    $appointment = Appointment::findOrFail($id);
    $appointment->delete();

    return redirect()->route('homePatient')->with('success', 'Appointment deleted successfully!');
}


    public function view3()
    {
        return view('successAppointment');
    }

  


    public function getUsersByDate(Request $request)
    {
        
        $request->validate([
            'appointment_date' => 'required|date',
        ]);
    
        $date = $request->input('appointment_date');
    
        
        $appointments = Appointment::whereDate('appointmentDate', $date)
            ->with('patient') 
            ->get();
    
        $users = $appointments->pluck('patient'); 
    
        return view('nurseList', [
            'users' => $users,
            'appointment_date' => $date,
            'medications' => Medication::all(),
        ]);
    }
    

}
