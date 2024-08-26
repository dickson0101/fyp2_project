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
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $authUserRole = Auth::user()->role;

        // 检查用户角色是否匹配
        if (($role == 'doctor' && $authUserRole == 0) ||
            ($role == 'nurse' && $authUserRole == 1) ||
            ($role == 'patient' && $authUserRole == 2)) {
            return $next($request);
        }

        // 根据用户角色重定向到相应页面
        switch ($authUserRole) {
            case 0:
                return redirect()->route('doctor');
            case 1:
                return redirect()->route('nurse');
            case 2:
                return redirect()->route('patient');
            default:
                return redirect()->route('login');
        }
    }
}
