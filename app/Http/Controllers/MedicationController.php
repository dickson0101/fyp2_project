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
    // Get the selected patient ID from the session
    $selectedPatientId = session('selected_patient_id');

    // If no patient ID is selected, you might want to handle it, e.g., redirect or show a message
    if (!$selectedPatientId) {
        return redirect()->route('doctorList')->with('error', 'No patient selected.');
    }

    // Filter medications for the selected patient
    $medications = Medication::where('patient_id', $selectedPatientId)->get();

    // Get medication IDs to fetch product prices
    $medicationIds = $medications->pluck('id');

    // Get corresponding product prices
    $products = Product::whereIn('id', $medicationIds)->get()->keyBy('id');

    // Calculate total amount
    $totalAmount = $medications->sum(function($medication) use ($products) {
        $product = $products->get($medication->id);
        return $product ? $product->price : 0;
    });

    // Return the view with medications, total amount, and selected patient ID
    return view('list', [
        'medications' => $medications,
        'totalAmount' => $totalAmount,
        'selectedPatientId' => $selectedPatientId
    ]);
}

    
    public function index2(){
        $medications = Medication::all();
    
        // 获取药品 ID 列表
        $medicationIds = $medications->pluck('id');
    
        // 从 Product 模型中获取对应的药品价格
        $products = Product::whereIn('id', $medicationIds)->get()->keyBy('id'); // Ensure the keyBy is 'id' if 'medication_id' is incorrect
    
        // 计算总价格
        $totalAmount = $medications->sum(function($medication) use ($products) {
            // 获取当前药品的价格
            $product = $products->get($medication->id);
            return $product ? $product->price : 0; // 假设 Product 模型有 price 字段
        });
    
        // 返回视图，传递药品列表和总价格
        return view('nurseList', ['medications' => $medications, 'totalAmount' => $totalAmount]);
    }

    public function create(Request $request)
{
    $medications = Product::all();
    $patient_name = $request->session()->get('selected_patient_name', 'No patient selected');
    return view('create', compact('medications', 'patient_name'));
}
    

  // 在 MedicationController 中的 store 方法
  public function store(Request $request)
  {
      // Validate data
      $validatedData = $request->validate([
          'name' => 'nullable|max:255', // Optional patient name
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

          // Create medication record
          Medication::create([
              'name' => $selectedPatientName,
              'patient_id' => $patientId, // Store patient_id
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
        $products = Product::all(); // Fetch all products for medication selection
        $patients = User::where('role', 'patient')->get(); // Fetch all patients
    
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
    // 获取medications表中所有存在的用户名称
    $existingUserNames = Medication::distinct()->pluck('name');
    
    // 从User模型中筛选出这些用户
    $users = User::whereIn('name', $existingUserNames)->get();

    // 获取选择的用户ID
    $patientId = $request->query('patient_id');
    
    // 构建查询
    $medicationsQuery = Medication::query();
    
    if ($patientId) {
        $medicationsQuery->where('patient_id', $patientId);
    }
    
    // 获取过滤后的medications
    $medications = $medicationsQuery->get();
    
    return view('nurseList', compact('users', 'medications', 'patientId'));
}

}

