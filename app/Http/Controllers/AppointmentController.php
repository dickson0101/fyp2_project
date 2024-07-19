<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Models\Product;

class AppointmentController extends Controller
{

    public function add(Request $request)
{


    Product::create([
        'name' => $request->medicationName,
        'description' => $request->medicationDescription,
        'expDate' => $request->expireDate,
        'price' => $request->prices,
        
        'publisher' => $request->publishers,
    ]);

    return view('addMedication');
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
