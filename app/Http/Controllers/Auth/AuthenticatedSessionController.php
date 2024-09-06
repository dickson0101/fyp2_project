<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    public function create(): View
    {
        return view('auth.login');
    }

    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();
        $request->session()->regenerate();
    
        $authUserRole = Auth::user()->role;
        \Log::info('User role:', ['role' => $authUserRole]);
    
        if ($authUserRole == 0) {
            return redirect()->intended('homeDoctor');
        } else if ($authUserRole == 1) {
            return redirect()->intended('nursePage');
        } else if ($authUserRole == 2) {
            return redirect()->intended('homePatient');
        }
    }
    
    
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
