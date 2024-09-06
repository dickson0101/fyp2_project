<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Models\Doctor;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function showHomePatient()
    {
        $appointments = Appointment::all(); 
        $appointment = Appointment::where('patient_id', auth()->id())->latest()->first();
        return view('homePatient', compact('appointment'));
    }
    

    public function viewDoctor()
    {
        $doctors = Doctor::all();
        return view('homeDoctor', ['doctors' => $doctors]);
    }

    public function viewNurse()
    {
        return view('nursePage');
    }

    public function homePage()
    {
        return view('homePage');
    }
}
