<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Models\Product;

class InventoryController extends Controller
{
    public function view(){
        return view('addInventory');
    }
}
