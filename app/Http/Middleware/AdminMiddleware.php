<?php

// app/Http/Middleware/AdminMiddleware.php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && Auth::user()->email === 'admin@admin.com' && Auth::user()->password === bcrypt('admin123')) {
            return $next($request);
        }

        return redirect('/login'); // Redirect to login if not authorized
    }
}
