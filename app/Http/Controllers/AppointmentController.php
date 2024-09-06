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
        // Get the doctor's time schedule
        $datesAndTimes = $doctor->dates_and_times;
        if (is_string($datesAndTimes)) {
            $datesAndTimes = json_decode($datesAndTimes, true);
        }

        // Debugging: Check if datesAndTimes is correctly decoded
        // Log::info('Doctor datesAndTimes:', $datesAndTimes);
        
        foreach ($datesAndTimes as $entry) {
            if ($entry['date'] === $date) {
                $unavailableTimes = array_merge($unavailableTimes, $entry['timeSlots']);
            }
        }
        $unavailableTimes = array_unique($unavailableTimes);

        // Get appointments for the specified doctor on the specified date
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

    // Get appointments for the given doctor based on the doctor_id in the Appointment model
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
        // 获取 appointmentDT 数据并解码
        $appointmentDTJson = $request->input('appointmentDT') ? json_decode($request->input('appointmentDT'), true) : null;
    
        // 确保 appointmentDT 数据存在
        if ($appointmentDTJson) {
            $doctorName = $request->input('doctorName'); // 确保请求中正确获取医生名字
    
            // 查找匹配的医生
            $doctor = User::where('name', $doctorName)->first();
    
            if ($doctor) {
                foreach ($appointmentDTJson as $entry) {
                    // 创建新的预约
                    $appointment = new Appointment();
                    $appointment->patient_id = Auth::id();
                    $appointment->doctor_id = $doctor->id;
                    $appointment->doctor = $doctorName;
                    $appointment->appointmentDate = $entry['date'];
                    $appointment->appointmentType = $request->input('appointmentType');
                    $appointment->timeSlot = json_encode($entry['timeSlots']); // 将时间槽编码为 JSON
                    $appointment->speciality = $request->input('specialitys');
                    $appointment->appointmentDT = json_encode($appointmentDTJson); // 存储整个 appointmentDT 数据
    
                    // 保存预约
                    $appointment->save();
                }
    
                return redirect()->route('homePatient')->with('success', 'Appointments created successfully!');
            }
        }
    
        // 如果未能创建预约，重新加载页面
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
            // Fetch appointments for the logged-in patient
            $appointments = Appointment::where('patient_id', Auth::id())
                                       ->orderBy('appointmentDate', 'asc')
                                       ->get();
            return view('homePatient', ['appointments' => $appointments]);
        }}

    public function showDoctorDashboard()
    {
        // Fetch appointments for the logged-in doctor
        $appointments = Appointment::where('doctor_id', Auth::id())
                                   ->orderBy('appointmentDate', 'asc')
                                   ->get();
        return view('homeDoctor', ['appointments' => $appointments]);
    }

    public function showNurseDashboard()
    {
        // Fetch all appointments for the nurse
        $appointments = Appointment::orderBy('appointmentDate', 'asc')
                                   ->get();
        return view('nursePage', ['appointments' => $appointments]);
    }
    
    

    public function edit($id)
    {
        $appointment = Appointment::findOrFail($id);
        $doctors = Doctor::all();
        $appointments = Appointment::all(); // Rename this to match the view variable
    
        return view('appointmentEdit', compact('appointment', 'doctors', 'appointments'));
    }
    
public function update(Request $request, $id)
{
    // Find the appointment by ID or fail if not found
    $appointment = Appointment::findOrFail($id);

    $doctorName = $request->input('doctorName'); // 确保请求中正确获取医生名字

    // 查找匹配的医生
    $doctor = User::where('name', $doctorName)->first();

    // Extract and process the time slots from the request
    $timeSlots = $request->input('selectedTimeSlot'); 
    $timeSlotsJson = $timeSlots ? json_encode(json_decode($timeSlots)) : null;

    if ($doctor) {
    $appointment->doctor_id = $doctor->id;
    $appointment->speciality = $request->specialitys;
    $appointment->doctor = $request->doctorName;
    $appointment->appointmentDate = $request->appointmentDate;
    $appointment->timeSlot = $timeSlotsJson; // Use the correct variable
    $appointment->appointmentType = $request->appointmentType;

    // Save the updated appointment
    $appointment->save();

    // Redirect to the appointment page with a success message
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
        // Validate the incoming request
        $request->validate([
            'appointment_date' => 'required|date',
        ]);
    
        $date = $request->input('appointment_date');
    
        // Retrieve users with appointments on the selected date
        $appointments = Appointment::whereDate('appointmentDate', $date)
            ->with('patient') // Assuming you have a 'patient' relationship
            ->get();
    
        $users = $appointments->pluck('patient'); // Extract patients
    
        // Pass data to the view
        return view('nurseList', [
            'users' => $users,
            'appointment_date' => $date,
            'medications' => Medication::all(),
        ]);
    }
    

}
