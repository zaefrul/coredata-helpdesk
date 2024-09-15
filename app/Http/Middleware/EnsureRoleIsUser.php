<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class EnsureRoleIsUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
        // Check if the authenticated user is a "user"
        if (Auth::check() && Auth::user()->role === 'user') {
            return $next($request);
        }

        // Redirect to the correct route for non-user roles
        return redirect()->route('dashboard'); // Or another route for non-users
    }
}
