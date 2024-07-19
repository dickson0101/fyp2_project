<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\myOrder;

use DB;
use App\Models\product;
use App\Models\myCart;
use Auth;
class CartController extends Controller
{
    public function __construct(){
        $this->middleware('auth');// require login before use
     }
 
     public function addCart(){
         $r=request();
         $add=myCart::create([
             
             'orderID'=>'',
             "productID"=>$r->id,
             'dateAdd'=>'',
             'userID'=>Auth::id(),
         ]);
         return redirect()->route('showProduct');
     }

    public function index(){
        $cart = DB::table('my_carts')
            ->leftjoin('products', 'products.id', '=', 'my_carts.productId')
            ->select('my_carts.orderID as cartQty','my_carts.id as cid', 'products.*')
            ->where('my_carts.orderID', '=' , '')
            ->where('my_carts.userID', '=', Auth::id())
            ->get();
            
           
    
        return view('myCart')->with('carts', $cart);
    }
    
    public function deleteFavorites(Request $request)
    {
        $selectedCartIds = $request->input('cid');

        foreach ($selectedCartIds as $cartId) {
            
            myCart::find($cartId)->delete();
        }

        return redirect()->back()->with('success', 'Selected favorites deleted successfully');
    }

}