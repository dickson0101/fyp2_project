<?php

namespace App\Http\Controllers;

use DB;
use App\Models\Product;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    public function add(Request $request)
    {
        // Validate the incoming request data if needed
        
        if ($request->file('medicationImage') != '') {
            $image = $request->file('medicationImage');
            $image->move('images', $image->getClientOriginalName());
            $imageName = $image->getClientOriginalName();
        } else {
            $imageName = 'empty.jpg';
        }

        // Create product and save to database
        Product::create([
            'name' => $request->medicationName,
            'description' => $request->medicationDescription,
            'expDate' => $request->expireDate,
            'stock' => $request->quantity, // Updated from stock to quantity
            'price' => $request->prices,
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
        $products = Product::where('id', $id)->get(); // Updated to use where
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
        $product->publisher = $request->publishers;
        $product->stock = $request->quantity; // Updated from stock to quantity

        $product->save(); // SQL update products set name='$productName',.....where id='$id'
        return redirect()->route('showProduct');
    }

    public function delete($id)
    {
        $product = Product::find($id);

        if (!$product) {
            // Handle case where the product with the given ID is not found
            return redirect()->route('addMedication')->with('error', 'Product not found');
        }

        // Delete the product image file
        $imagePath = public_path('images') . '/' . $product->image;
        if (file_exists($imagePath)) {
            unlink($imagePath);
        }

        // Delete the product from the database
        $product->delete();

        return redirect()->route('showProduct')->with('success', 'Product deleted successfully');
    }
}
