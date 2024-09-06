<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleManager
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @param  string  $role
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, $role)
    {
        // Ensure user is authenticated
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $authUserRole = Auth::user()->role;

        // Check if the user's role matches the required role
        if ($this->roleMatches($role, $authUserRole)) {
            return $next($request);
        }

        // Redirect based on user role
        return $this->redirectBasedOnRole($authUserRole);
    }

    /**
     * Check if the user's role matches the required role.
     *
     * @param  string  $role
     * @param  int  $authUserRole
     * @return bool
     */
    private function roleMatches($role, $authUserRole)
    {
        $roles = [
            'doctor' => 0,
            'nurse' => 1,
            'homePatient' => 2,
        ];

        return isset($roles[$role]) && $roles[$role] === $authUserRole;
    }

    /**
     * Redirect user based on their role.
     *
     * @param  int  $authUserRole
     * @return \Illuminate\Http\RedirectResponse
     */
    private function redirectBasedOnRole($authUserRole)
    {
        switch ($authUserRole) {
            case 0:
                return redirect()->route('homeDoctor');
            case 1:
                return redirect()->route('nursePage');
            case 2:
                return redirect()->route('homePatient');
            default:
                return redirect()->route('login');
        }
    }
}
