<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
public function handle(Request $request, Closure $next)
{
    if (Auth::check()) {
        // Check if the authenticated user is either admin or staff
        if (Auth::user()->usertype === 'admin' || Auth::user()->usertype === 'staff') {
            return $next($request); 
        }

        // Redirect unauthorized users
        return redirect()->route('home.index')->with('error', 'Unauthorized access.');
    }

    // If not authenticated, redirect to the login page
    return redirect()->route('login');
}

}
