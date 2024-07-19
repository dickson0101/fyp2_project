<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;
use App\Models\myCart;
use App\Models\myOrder;
use PDF;

class OrderController extends Controller
{
    public function __construct(){
        $this->middleware('auth');//require login before use
}

public function pdfReport(){
    $orders = DB::table('my_orders')->select
    ('my_orders.*')
    ->where('my_orders.userID','=',Auth::id())
    ->get();
    $pdf = PDF::loadView('myPDF', compact('orders'));
    return $pdf->download('Order_report.pdf');
}

public function index(){
    $orders = DB::table('my_orders')->select
    ('my_orders.*')
    ->where('my_orders.userID','=',Auth::id())
    ->get();
    return view('myOrder')->with('orders', $orders);
}


}
