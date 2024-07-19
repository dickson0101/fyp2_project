<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\feedback;
use DB;

class feedbackController extends Controller
{
    public function feedback (){
        $r = request();
        $add = feedback::create([
        'firstName'=>'firstName',
        'lastName'=>'lastName',
        'email'=>'email',
        'content'=>'content',
        ]);

        

        return redirect()->route('feedback'
    );
  }
}
