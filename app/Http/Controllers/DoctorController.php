<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Models\Doctor;

class DoctorController extends Controller
{
public function view()
    {
        return view('doctorAdd');
    }

    public function add(Request $request)
{
    // Validate the incoming request data if needed
    
    if ($request->file('DoctorImage')) {
        $image = $request->file('DoctorImage');
        $image->move('images', $image->getClientOriginalName());
        $imageName = $image->getClientOriginalName();
    } else {
        $imageName = 'empty.jpg';
    }

    // Create doctor and save to database
    Doctor::create([
        'name' => $request->DoctorName,
        'image' => $imageName,
        'certificate' => $request->Certificate,
        'specialist' => $request->Specialist,
        'telephone' => $request->Telephone,
        'language' => $request->Language,
        'consultation_date' => $request->ConsultationDate,
        'consultation_time' => $request->ConsultationTime,
    ]);

    return view('doctorAdd');
}
}