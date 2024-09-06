<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Doctor;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class DoctorController extends Controller
{
    // Add Doctor Method
    public function add(Request $request)
    {
        // Validate request data
        $validator = Validator::make($request->all(), [
            'DoctorName' => 'required|string|max:255',
            'DoctorEmail' => 'required|email|unique:users,email',
            'DoctorPassword' => 'required|string|min:8',
            'Certificate' => 'required|string|max:255',
            'Specialist' => 'required|string|max:255',
            'Telephone' => 'required|digits:11',
            'Language' => 'required|array',
            'DoctorImage' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'datesAndTimes' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Handle DoctorImage
        $imageName = 'empty.jpg';
        if ($request->hasFile('DoctorImage')) {
            $image = $request->file('DoctorImage');
            $imageName = time() . '-' . $image->getClientOriginalName();
            $image->move(public_path('images'), $imageName);
        }

        // Handle dates and times
        $datesAndTimesJson = $request->input('datesAndTimes') ? json_decode($request->input('datesAndTimes'), true) : null;

        // Create new doctor record
        $doctor = Doctor::create([
            'name' => $request->input('DoctorName'),
            'image' => $imageName,
            'certificate' => $request->input('Certificate'),
            'specialist' => $request->input('Specialist'),
            'telephone' => $request->input('Telephone'),
            'language' => implode(', ', $request->input('Language')),  // Storing the languages as a comma-separated string
            'dates_and_times' => json_encode($datesAndTimesJson),
        ]);

        // Create user account for doctor
        User::create([
            'name' => $request->input('DoctorName'),
            'email' => $request->input('DoctorEmail'),
            'password' => Hash::make($request->input('DoctorPassword')),
            'role' => 0, // Set role to 0 for doctor
            'doctor_id' => $doctor->id,
        ]);

        return redirect()->route('doctorPage')->with('success', 'Doctor added successfully!');
    }

    public function edit($id)
    {
        $doctor = Doctor::findOrFail($id);
        return view('doctorEdit', compact('doctor'));
    }
    public function update(Request $request, $id)
    {
        // Validate request data
        $validator = Validator::make($request->all(), [
            'DoctorName' => 'required|string|max:255',
            'DoctorEmail' => 'required|email|unique:users,email,' . User::where('doctor_id', $id)->first()->id,
            'DoctorPassword' => 'nullable|string|min:8',
            'Certificate' => 'required|string|max:255',
            'Specialist' => 'required|string|max:255',
            'Telephone' => 'required|digits:11',
            'Language' => 'required|array',
            'DoctorImage' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'datesAndTimes' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Find the doctor record
        $doctor = Doctor::findOrFail($id);

        // Handle image upload and update
        if ($request->hasFile('DoctorImage')) {
            $image = $request->file('DoctorImage');
            $imageName = time() . '-' . $image->getClientOriginalName();
            $image->move(public_path('images'), $imageName);
            $doctor->image = $imageName;
        }

        // Update doctor details
        $doctor->name = $request->input('DoctorName');
        $doctor->certificate = $request->input('Certificate');
        $doctor->specialist = $request->input('Specialist');
        $doctor->telephone = $request->input('Telephone');
        $doctor->language = implode(', ', $request->input('Language'));

        // Handle dates and times
        $datesAndTimesJson = $request->input('datesAndTimes') ? json_decode($request->input('datesAndTimes'), true) : null;
        $doctor->dates_and_times = json_encode($datesAndTimesJson);

        $doctor->save();

        // Update the associated user record if it exists
        $user = User::where('doctor_id', $doctor->id)->first();
        if ($user) {
            $user->name = $request->input('DoctorName');
            $user->email = $request->input('DoctorEmail');

            // Update password if provided
            if ($request->filled('DoctorPassword')) {
                $user->password = Hash::make($request->input('DoctorPassword'));
            }

            $user->save();
        }

        return redirect()->route('doctorPage')->with('success', 'Doctor and associated user updated successfully!');
    }


    public function view()
    {
        $doctors = Doctor::all();
        return view('doctorPage', ['doctors' => $doctors]);
    }

    public function search(Request $request)
    {
        $query = $request->input('search');
        $doctors = Doctor::where(function ($q) use ($query) {
            $q->where('name', 'like', "%$query%")
              ->orWhere('email', 'like', "%$query%");
        })->get();
    
        return view('doctor.index', compact('doctors'));
    }

    public function delete($id)
    {
        $doctor = Doctor::find($id);

        if (!$doctor) {
            return redirect()->route('doctorPage')->with('error', 'Doctor not found');
        }

        // Delete associated user account
        $user = User::where('doctor_id', $doctor->id)->first();
        if ($user) {
            $user->delete();
        }

        // Delete doctor's image file if it exists
        $imagePath = public_path('images') . '/' . $doctor->image;
        if (file_exists($imagePath)) {
            unlink($imagePath);
        }

        // Delete the doctor record
        $doctor->delete();

        return redirect()->route('doctorPage')->with('success', 'Doctor and associated user deleted successfully');
    }

    public function confirmDelete($id)
    {
        $doctor = Doctor::find($id);
        if (!$doctor) {
            return redirect()->route('doctorPage')->with('error', 'Doctor not found');
        }

        return view('confirmDelete', ['doctor' => $doctor]);
    }
}
