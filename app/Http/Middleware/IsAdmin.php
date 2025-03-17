<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IsAdmin
{
    public function handle(Request $request, Closure $next)
    {
        // Pastikan user sudah login dan memiliki role sebagai 'admin'
        if (Auth::check() && Auth::user()->is_admin == 1) {
            return $next($request);
        }

        // Redirect ke halaman utama jika bukan admin
        return redirect('/')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
    }
}
