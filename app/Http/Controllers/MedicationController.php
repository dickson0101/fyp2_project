<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Medication;
use App\Models\Product;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class MedicationController extends Controller
{
    public function index()
    {
        // 从 Medication 模型中获取药品列表
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
        return view('list', ['medications' => $medications, 'totalAmount' => $totalAmount]);
    }
    

    public function create(){

    $medications = Product::all();
    return view('create', compact('medications'));

    }

    public function store(Request $request)
{
    $validatedData = $request->validate([
        'name' => 'required|max:255',
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

    foreach ($validatedData['medication'] as $key => $medicationName) {
        $product = Product::where('name', $medicationName)->first();
        $price = $product ? $product->price : 0; // Default price if not found

        $dosage = "{$validatedData['tablets'][$key]} Tablet, {$validatedData['frequency'][$key]} Time Daily, {$validatedData['meal_relation'][$key]} Eating";
        
        Medication::create([
            'name' => $validatedData['name'],
            'medication' => $medicationName,
            'price' => $price,
            'dosage' => $dosage,
            'created_at' => Carbon::parse($validatedData['date_added'][$key]),
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
}