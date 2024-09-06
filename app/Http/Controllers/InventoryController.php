<?php

namespace App\Http\Controllers;

use DB;
use App\Models\Product;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    public function add(Request $request)
    {
        
        
        if ($request->file('medicationImage') != '') {
            $image = $request->file('medicationImage');
            $image->move('images', $image->getClientOriginalName());
            $imageName = $image->getClientOriginalName();
        } else {
            $imageName = 'empty.jpg';
        }

        
        Product::create([
            'name' => $request->medicationName,
            'description' => $request->medicationDescription,
            'expDate' => $request->expireDate,
            'stock' => $request->quantity, 
            'price' => $request->prices,
            'batch' => $request->batchNo,
            'appDate' => $request->dateAppro,
            'image' => $imageName,
            'publisher' => $request->publishers,
        ]);

        return view('addMedication');
    }

    public function view()
    {
        $products = Product::all();
        return view('showProduct')->with('products', $products);
    }

    public function edit($id)
    {
        $products = Product::where('id', $id)->get(); 
        return view('editProduct')->with('products', $products);
    }

    public function update(Request $request)
    {
        $product = Product::find($request->id);
        if ($request->file('medicationImage')) {
            $image = $request->file('medicationImage');
            $image->move('images', $image->getClientOriginalName());
            $imageName = $image->getClientOriginalName();
            $product->image = $imageName;
        }

        $product->name = $request->medicationName;
        $product->description = $request->medicationDescription;
        $product->expDate = $request->expireDate;
        $product->price = $request->prices;
        $product->batch = $request->batchNo;
        $product->appDate = $request->dateAppro;
        $product->publisher = $request->publishers;
        $product->stock = $request->quantity; 

        $product->save(); 
        return redirect()->route('showProduct');
    }

    public function delete($id)
    {
        $product = Product::find($id);

        if (!$product) {
            
            return redirect()->route('addMedication')->with('error', 'Product not found');
        }

        
        $imagePath = public_path('images') . '/' . $product->image;
        if (file_exists($imagePath)) {
            unlink($imagePath);
        }

        
        $product->delete();

        return redirect()->route('showProduct')->with('success', 'Product deleted successfully');
    }

    public function search(Request $request)
{
    
    $searchTerm = $request->input('searchTerm');

    
    $products = Product::where('name', 'like', "%{$searchTerm}%")
                        ->orWhere('description', 'like', "%{$searchTerm}%")
                        ->orWhere('batchNo', 'like', "%{$searchTerm}%")
                        ->get();

    
    return view('showProduct')->with('products', $products);
}

}
