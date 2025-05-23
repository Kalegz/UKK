<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (!Auth::check()) return redirect('login');
        
        $user = Auth::user();
        foreach ($roles as $role) {
            if (
                ($role === 'student' && $user->isStudent()) ||
                ($role === 'teacher' && $user->isTeacher()) ||
                ($role === 'admin' && $user->isAdmin())
            ) return $next($request);
        }
        
        abort(403);
    }
}