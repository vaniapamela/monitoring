<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // 1. Cek apakah user sudah login, jika belum atau rolenya tidak sesuai daftar yang diizinkan
        if (!$request->user() || !in_array($request->user()->role, $roles)) {

            // 2. Tendang balik ke halaman depan (landing page) dengan pesan error
            return redirect('/')->with('error', 'Akses ditolak! Halaman monitoring hanya untuk Penyewa Gudang.');
        }

        return $next($request);
    }
}