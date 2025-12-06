<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // INI YANG KAMU LUPA IMPORT!
use Symfony\Component\HttpFoundation\Response;

class Admin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Pastikan user sudah login dan role-nya admin
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            // Kalau bukan admin → redirect ke home atau halaman login
            return redirect()->route('home')->with('error', 'Akses ditolak! Hanya Admin.');
        }

        return $next($request);
    }
}