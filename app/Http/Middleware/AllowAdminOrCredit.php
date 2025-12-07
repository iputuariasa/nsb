<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AllowAdminOrCredit
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return redirect('/login');
        }

        $user = Auth::user();

        if (in_array($user->role, ['admin', 'credit'])) {
            return $next($request);
        }

        // Kalau bukan admin atau credit → tolak
        abort(403, 'Akses ditolak!');
        // atau redirect:
        // return redirect()->route('home')->with('error', 'Akses ditolak!');
    }
}