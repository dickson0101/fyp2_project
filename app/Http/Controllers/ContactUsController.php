<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\contactUs;
use DB;

class contactUsController extends Controller
{
    public function contactUs (){
        $r = request();
        $add = contactUs::create([
        'name'=>'name',
        'email'=>'email',
        'description'=>'description',
        ]);

        

        return redirect()->route('contactUs'
    );
  }
}
