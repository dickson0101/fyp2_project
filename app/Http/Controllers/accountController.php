<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class accountController extends Controller
{
    public function update(Request $request)
    {
        $user = Auth::user();

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'contactNumber' => 'required|string|max:15',
            'gender' => 'required|string',
            'maykad' => 'required|string|size:12',
            'dateOfBirth' => 'required|date',
            'address1' => 'required|string|max:255',
            'address2' => 'required|string|max:255',
            'postcode' => 'required|string|max:10',
            'state' => 'required|string',
            'city' => 'required|string|max:255',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        // Update user data
        $user->name = $validatedData['name'];
        $user->email = $validatedData['email'];
        $user->contactNumber = $validatedData['contactNumber'];
        $user->gender = $validatedData['gender'];
        $user->maykad = $validatedData['maykad'];
        $user->dateOfBirth = $validatedData['dateOfBirth'];
        $user->address1 = $validatedData['address1'];
        $user->address2 = $validatedData['address2'];
        $user->postcode = $validatedData['postcode'];
        $user->state = $validatedData['state'];
        $user->city = $validatedData['city'];

        // Check if password is provided and update it
        if (!empty($validatedData['password'])) {
            $user->password = Hash::make($validatedData['password']);
        }

        $user->save();

        return redirect()->back()->with('success', 'Profile updated successfully.');
    }
}



