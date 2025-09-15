<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckSuperAdmin
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::guard('admin')->check() && Auth::guard('admin')->user()->Super_Admin) {
            return $next($request);
        }

        return redirect()->route('admin.dashboard')
            ->with('error', 'ليس لديك صلاحية للوصول إلى هذه الصفحة.');
    }
}
