<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Medication;
use App\Models\Product;
use App\Models\User;    
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class MedicationController extends Controller
{
    public function index()
{
    
    $selectedPatientId = session('selected_patient_id');

    
    if (!$selectedPatientId) {
        return redirect()->route('doctorList')->with('error', 'No patient selected.');
    }

    
    $medications = Medication::where('patient_id', $selectedPatientId)->get();

    
    $medicationIds = $medications->pluck('id');

   
    $products = Product::whereIn('id', $medicationIds)->get()->keyBy('id');

    
    $totalAmount = $medications->sum(function($medication) use ($products) {
        $product = $products->get($medication->id);
        return $product ? $product->price : 0;
    });

    
    return view('list', [
        'medications' => $medications,
        'totalAmount' => $totalAmount,
        'selectedPatientId' => $selectedPatientId
    ]);
}

    
    public function index2(){
        $medications = Medication::all();
    
        
        $medicationIds = $medications->pluck('id');
    
       
        $products = Product::whereIn('id', $medicationIds)->get()->keyBy('id'); // Ensure the keyBy is 'id' if 'medication_id' is incorrect
    
        
        $totalAmount = $medications->sum(function($medication) use ($products) {
            
            $product = $products->get($medication->id);
            return $product ? $product->price : 0; 
        });
    
        
        return view('nurseList', ['medications' => $medications, 'totalAmount' => $totalAmount]);
    }

    public function create(Request $request)
{
    $medications = Product::all();
    $patient_name = $request->session()->get('selected_patient_name', 'No patient selected');
    return view('create', compact('medications', 'patient_name'));
}
    

 
  public function store(Request $request)
  {
      
      $validatedData = $request->validate([
          'name' => 'nullable|max:255', 
          'medication' => 'required|array',
          'medication.*' => 'required|max:255',
          'tablets' => 'required|array',
          'tablets.*' => 'required|integer',
          'frequency' => 'required|array',
          'frequency.*' => 'required|integer',
          'meal_relation' => 'required|array',
          'meal_relation.*' => 'required|in:before,after',
          'date_added' => 'required|array',
          'date_added.*' => 'required|date',
      ]);

      $validatedData['patient_id'] = $request->session()->get('selected_patient_id');
      $patientId = $validatedData['patient_id']; 
      $selectedPatientName = $request->session()->get('selected_patient_name', 'Unknown Patient');

      foreach ($validatedData['medication'] as $key => $medicationName) {
          $product = Product::where('name', $medicationName)->first();
          $price = $product ? $product->price : 0;

          $dosage = "{$validatedData['tablets'][$key]} Tablet(s), {$validatedData['frequency'][$key]} Time(s) Daily, {$validatedData['meal_relation'][$key]} Eating";

         
          Medication::create([
              'name' => $selectedPatientName,
              'patient_id' => $patientId, 
              'medication' => $medicationName,
              'price' => $price,
              'dosage' => $dosage,
              'date_added' => Carbon::parse($validatedData['date_added'][$key]),
          ]);
      }

      return redirect()->route('medications.list')->with('success', 'Medications added successfully');
  }


    public function updateMedicationQuantities(Request $request)
    {
        $validatedData = $request->validate([
            'medications' => 'required|array',
            'medications.*' => 'required|string',
            'quantities' => 'required|array',
            'quantities.*' => 'required|integer',
        ]);

        foreach ($validatedData['medications'] as $key => $medicationName) {
            $quantity = $validatedData['quantities'][$key];
            $product = Product::where('name', $medicationName)->first();
            if ($product && $quantity > 0) {
                $product->stock -= $quantity;
                $product->save();
            }
        }

        return redirect()->route('medications.list')->with('success', 'Medication quantities updated successfully');
    }

    public function destroy($id)
    {
        $medication = Medication::findOrFail($id);
        $medication->delete();

        return redirect()->route('medications.list')->with('success', 'Medication deleted successfully');
    }

    public function destroy2($id)
    {
        $medication = Medication::findOrFail($id);
        $medication->delete();

        return redirect()->route('nurseList')->with('success', 'Medication deleted successfully');
    }

   public function edit($id)
    {
        $medication = Medication::findOrFail($id);
        $products = Product::all(); 
        $patients = User::where('role', 'patient')->get(); 
    
        return view('editMedication', compact('medication', 'products', 'patients'));
    }


    public function update(Request $request, $id)
{
    $validatedData = $request->validate([
        'name' => 'required|string|max:255',
        'medication' => 'required|string|max:255',
        'tablets' => 'required|integer',
        'frequency' => 'required|integer',
        'meal_relation' => 'required|in:before,after',
        'date_added' => 'required|date',
        'price' => 'required|numeric',
    ]);

    $medication = Medication::findOrFail($id);

    $dosage = "{$validatedData['tablets']} Tablet(s), {$validatedData['frequency']} Time(s) Daily, {$validatedData['meal_relation']} Eating";

    $medication->update([
        'name' => $validatedData['name'],
        'medication' => $validatedData['medication'],
        'price' => $validatedData['price'],
        'dosage' => $dosage,
        'date_added' => Carbon::parse($validatedData['date_added']),
    ]);

    return redirect()->route('medications.list')->with('success', 'Medication updated successfully');
}
    
    
    public function list(Request $request)
{
    
    $existingUserNames = Medication::distinct()->pluck('name');
    
    
    $users = User::whereIn('name', $existingUserNames)->get();

    
    $patientId = $request->query('patient_id');
    
    $medicationsQuery = Medication::query();
    
    if ($patientId) {
        $medicationsQuery->where('patient_id', $patientId);
    }
    
   
    $medications = $medicationsQuery->get();
    
    return view('nurseList', compact('users', 'medications', 'patientId'));
}

}

