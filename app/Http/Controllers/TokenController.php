<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TokenController extends Controller
{
    public function getToken(Request $request) {
        try {
            $channel = $request->query('channel');
            if (!$channel) {
                return response()->json(['error' => 'Channel name is required'], 400);
            }
            
            $token = $this->generateTokenForChannel($channel); // Implement this method
            
            return response()->json(['token' => $token]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    
}
