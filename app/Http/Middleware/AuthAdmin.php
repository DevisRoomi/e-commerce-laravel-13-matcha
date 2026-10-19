<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class AuthAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Cek apakah user sudah login DAN memiliki tipe 'ADM' (Admin)
        if (Auth::check() && Auth::user()->utype === 'ADM') {
            return $next($request);
        }

        // Jika bukan admin (atau user biasa), tendang keluar ke halaman login
        Auth::logout();
        return redirect()->route('login');
    }
}
