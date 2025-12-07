<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class Credit
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Pastikan user sudah login dan role-nya credit
        if (!Auth::check() || Auth::user()->role !== 'credit') {
            // Kalau bukan credit → redirect ke home atau halaman login
            return redirect()->route('home')->with('error', 'Akses ditolak!');
        }

        return $next($request);
    }
}