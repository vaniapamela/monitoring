<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DeviceModel;
use App\Models\User; // Pastikan ini ada dan folder/file benar
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function index()
    {
        // Pastikan relasi 'devices' sudah didefinisikan di Model User
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
            'device_name' => 'nullable|string|max:255',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        // Simpan device jika device_name diisi
        if ($request->filled('device_name')) {
            DeviceModel::create([
                'user_id' => $user->id,
                'device_name' => $request->device_name,
                'api_key' => Str::random(32),
            ]);
        }

        return redirect()->route('admin.users.index')->with('success', 'User berhasil ditambahkan!');
    }

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

        // Logic update device
        if ($request->filled('device_name')) {
            Device::updateOrCreate(
                ['user_id' => $user->id],
                ['device_name' => $request->device_name]
            );
        }

        return redirect()->route('admin.users.index')->with('success', 'User & Device berhasil diupdate!');
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

        return redirect()->route('admin.users.index')->with('success', 'Akun telah dihapus.');
    }
}
