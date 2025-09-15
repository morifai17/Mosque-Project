<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TeacherAuthenticate
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::guard('teacher')->check()) {
            return $next($request);
        }

        return response()->json([
            'success' => false,
            'message' => 'غير مصرح بالوصول. يلزم تسجيل الدخول كمعلم.'
        ], 401);
    }
}
