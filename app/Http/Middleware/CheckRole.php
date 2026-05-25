<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        // 1. Cek apakah user sudah login
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // Ambil data role user dari DB dan ubah paksa ke huruf kecil murni
        $userRole = strtolower(Auth::user()->role);
        $targetRole = strtolower($role);

        // 2. Cek apakah role user sesuai
        if ($userRole === $targetRole) {
            return $next($request); 
        }

        // 3. JIKA TIDAK SESUAI, Arahkan berdasarkan role yang dimiliki:
        
        // Jika dia Admin, paksa ke halaman admin
        if ($userRole === 'admin') {
            return redirect()->route('admin.users.index');
        }

        // Jika dia Tenant/User, paksa ke halaman monitoring
        if ($userRole === 'tenant' || $userRole === 'user') {
            return redirect()->route('monitoring');
        }

        // Jika tidak dikenali, lempar ke beranda
        return redirect('/')->with('error', 'Akses ditolak.');
    }
}