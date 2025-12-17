<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        // Cek apakah user sudah login
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Please login first');
        }

        // Cek apakah user adalah admin
        if (!auth()->user()->is_admin) {
            return redirect()->route('home')->with('error', 'Unauthorized access. Admin only!');
        }

        return $next($request);
    }
}