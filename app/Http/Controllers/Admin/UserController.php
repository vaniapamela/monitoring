<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Device; // Jangan lupa import model Device
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        // 1. Tambahkan 'devices' ke dalam with() agar data token bisa diakses
        $users = User::with(['devices'])
            ->where('id', '!=', auth()->id())
            ->get();
        
        $totalLogins = User::sum('login_count');
        $usersLoggedInToday = User::whereDate('last_login_at', today())->count();
        
        return view('admin.users.index', compact('users', 'totalLogins', 'usersLoggedInToday'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'role' => 'required|in:tenant,guest',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        // Jika saat tambah user langsung ada token
        if ($request->filled('token')) {
            Device::create(['user_id' => $user->id, 'token' => $request->token]);
        }

        return redirect()->route('admin.users.index')->with('success', 'User berhasil ditambahkan!');
    }

    /**
     * 3. Aksi Update: Mengedit User & Token
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        if ($request->filled('password')) {
            $user->update(['password' => Hash::make($request->password)]);
        }

        // Logic Update/Create Token
        if ($request->filled('token')) {
            Device::updateOrCreate(
                ['user_id' => $user->id],
                ['token' => $request->token]
            );
        }

        return redirect()->route('admin.users.index')->with('success', 'User & Token berhasil diupdate!');
    }

    public function toggleStatus($id)
    {
        $user = User::findOrFail($id);
        $user->role = ($user->role === 'tenant') ? 'guest' : 'tenant';
        $user->save();

        $pesan = ($user->role === 'tenant') ? "{$user->name} kini jadi Penyewa." : "Akses {$user->name} dicabut.";
        return redirect()->route('admin.users.index')->with('success', $pesan);
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->route('admin.users.index')->with('success', "Akun telah dihapus.");
    }
}