<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    // 1. Menampilkan semua daftar user di halaman admin
    public function index()
    {
        $users = User::all();
        return view('admin.users.index', compact('users'));
    }

    // 2. Mengubah role user menjadi 'tenant' (Penyewa)
    public function makeTenant($id)
    {
        $user = User::findOrFail($id);
        $user->role = 'tenant';
        $user->save();

        return redirect()->back()->with('success', 'User ' . $user->name . ' berhasil diaktifkan sebagai Penyewa!');
    }

    // 3. Mengembalikan role user menjadi 'guest' (Orang Luar) jika masa sewa habis
    public function makeGuest($id)
    {
        $user = User::findOrFail($id);
        $user->role = 'guest';
        $user->save();

        return redirect()->back()->with('success', 'Status penyewa ' . $user->name . ' telah dinonaktifkan.');
    }
}