<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Models\Product;
class ProductController extends Controller
{
    public function add()
    {
        $r = request(); 
    
       
    
        if ($r->file('productImage') != '') {
            $image = $r->file('productImage');
            $image->move('images', $image->getClientOriginalName());
            $imageName = $image->getClientOriginalName();
        } else {
            $imageName = 'empty.jpg';
        }
    
        $add = Product::create([
            'name' => $r->productName,
            'description' => $r->productDescription,
            'requirement' => $r->productRequirement,
            'price' => $r->productPrice,
            'image' => $imageName,
            'developer' => $r->productDeveloper,
            'publisher' => $r->productPublisher,
        ]);
    
        return view('addProduct');
    }
    
    public function view(){
        $products = Product::all();
        return view('showProduct')->with('products', $products);
    }
    


    public function edit($id){
        $products=Product::all()->where('id',$id);//select * from products where id ='$id'
        return view('editProduct')->with('products',$products);
    }

    public function productDetail($id){
        $products=Product::all()->where('id',$id);//select * from products where id ='$id'
        return view('showProductDetail')->with('products',$products);
    }
    

    public function update(){
        $r=request();
        $product=Product::find($r->id);
        if($r->file('productImage')){
            $image=$r->file('productImage');
            $image->move('images',$image->getClientOriginalName());
            $imageName=$image->getClientOriginalName();
            $product->image=$imageName;
        }
        $product->name=$r->productName;
        $product->description=$r->productDescription;
        $product->price=$r->productPrice;
        $product->requirement=$r->productRequirement;
        $product->developer = $r->productDeveloper;
        $product->publisher = $r->productPublisher;
       
        $product->save();//SQL update products set name='$productName',.....where id='$id'
        return redirect()->route('showProduct');
    }

    public function search()
    {
        $r = request();
        $keyword = $r->searchProduct;
        $viewProduct=DB::table('products')
            ->select('products.*') 
            ->where('products.name', 'like', '%' . $keyword . '%')
            ->orWhere('products.description','like','%'.$keyword.'%')
            ->get();

        return view('showProduct')->with('products', $viewProduct);
    }


    
    public function delete($id)
{
    $product = Product::find($id);

    if (!$product) {
        // Handle case where the product with the given ID is not found
        return redirect()->route('showProduct')->with('error', 'Product not found');
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

